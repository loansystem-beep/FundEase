<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserAutoPaymentController extends Controller
{
    public function callback(Request $request)
    {
        Log::info('M-Pesa Callback Received', ['body' => $request->getContent()]);

        $data = json_decode($request->getContent());
        $stkCallback = $data->Body->stkCallback ?? null;

        if (!$stkCallback) {
            Log::error('Missing stkCallback in M-Pesa callback');
            return response()->json(['message' => 'Invalid callback data'], 400);
        }

        $checkoutRequestId = $stkCallback->CheckoutRequestID;
        $resultCode = $stkCallback->ResultCode;

        $payment = Payment::where('checkout_request_id', $checkoutRequestId)->first();

        if (!$payment) {
            Log::warning('No payment found for CheckoutRequestID: ' . $checkoutRequestId);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $status = $resultCode == 0 ? Payment::STATUS_COMPLETED : Payment::STATUS_FAILED;
        $transactionCode = null;

        if ($resultCode == 0 && isset($stkCallback->CallbackMetadata->Item)) {
            foreach ($stkCallback->CallbackMetadata->Item as $item) {
                if ($item->Name === 'MpesaReceiptNumber') {
                    $transactionCode = $item->Value;
                    break;
                }
            }
        }

        // Use DB transactions to ensure data integrity
        DB::beginTransaction();

        try {
            // Update payment status
            $payment->update([
                'status' => $status,
                'mpesa_transaction_code' => $transactionCode,
                'paid_at' => now()
            ]);

            if ($status === Payment::STATUS_COMPLETED) {
                $user = $payment->user;

                if ($user && $user->status === 'inactive') {
                    // Update user status to active
                    $user->update([
                        'status' => 'active',
                        'is_active' => true,
                        'activated_at' => now()
                    ]);

                    // Update expires_at as well based on activation time
                    $user->setExpiresFromActivation();
                    $user->save();

                    Log::info("User {$user->id} activated after payment.");
                }
            }

            DB::commit();
            return response()->json(['message' => 'Callback processed']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing callback: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing callback'], 500);
        }
    }
}
