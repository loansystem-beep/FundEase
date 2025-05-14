<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PaymentController extends Controller
{
    public function form()
    {
        return view('payment.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'mpesa_number' => ['required', 'string', 'regex:/^(07|011)[0-9]{8}$/'],
        ]);

        $phone = ltrim($validated['mpesa_number'], '+');
        if (str_starts_with($phone, '07')) {
            $phone = '254' . substr($phone, 1);
        } elseif (str_starts_with($phone, '011')) {
            $phone = '254' . substr($phone, 1);
        }

        // ✅ Correctly reading from config/services.php
        $shortcode = config('services.mpesa.shortcode');
        $passkey = config('services.mpesa.passkey');
        $consumerKey = config('services.mpesa.consumer_key');
        $consumerSecret = config('services.mpesa.consumer_secret');
        $callbackUrl = config('services.mpesa.callback_url');

        // Fail early if any critical value is missing
        if (!$shortcode || !$passkey || !$consumerKey || !$consumerSecret || !$callbackUrl) {
            Log::error('Missing required M-Pesa credentials.');
            return back()->with('error', 'M-Pesa configuration is incomplete.');
        }

        Log::info('Initiating STK Push with phone: ' . $phone);

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($shortcode . $passkey . $timestamp);

        $tokenRes = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        if (!$tokenRes->successful()) {
            Log::error('M-Pesa token error: ' . $tokenRes->body());
            return back()->with('error', 'Failed to get M-Pesa access token.');
        }

        $accessToken = $tokenRes->json()['access_token'];

        $response = Http::withToken($accessToken)->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            "BusinessShortCode" => $shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $validated['amount'],
            "PartyA" => $phone,
            "PartyB" => $shortcode,
            "PhoneNumber" => $phone,
            "CallBackURL" => $callbackUrl,
            "AccountReference" => "Fundease Payment",
            "TransactionDesc" => "Payment for loan"
        ]);

        Log::info('M-Pesa STK Push Response: ' . $response->body());

        if ($response->successful()) {
            $responseData = $response->json();
            Payment::create([
                'user_id' => auth()->id(),
                'amount' => $validated['amount'],
                'status' => 'pending',
                'mpesa_number' => $phone,
                'mpesa_transaction_code' => $responseData['CheckoutRequestID'] ?? null,
            ]);

            return back()->with('success', 'STK Push sent. Complete payment on your phone.');
        }

        return back()->with('error', 'STK Push failed: ' . $response->body());
    }

    public function callback(Request $request)
    {
        Log::info('M-Pesa Callback Received', $request->all());

        $transactionCode = $request->input('TransactionID');
        $resultCode = $request->input('ResultCode');

        if (!$transactionCode || is_null($resultCode)) {
            Log::error('Invalid M-Pesa callback payload.');
            return response()->json(['message' => 'Invalid callback data'], 400);
        }

        $status = $resultCode == 0 ? 'completed' : 'failed';

        $payment = Payment::where('mpesa_transaction_code', $transactionCode)->first();

        if ($payment) {
            $payment->update([
                'status' => $status,
                'paid_at' => now()
            ]);

            if ($status === 'completed') {
                $user = $payment->user;
                if ($user && $user->status === 'inactive') {
                    $user->update([
                        'status' => 'active',
                        'is_active' => 1,
                        'activated_at' => now()
                    ]);
                    Log::info("User {$user->id} activated after payment.");
                }
            }
        } else {
            Log::warning('No payment found with transaction code: ' . $transactionCode);
        }

        return response()->json(['message' => 'Callback received']);
    }
}
