<?php

namespace App\Http\Controllers;

use App\Models\Repayment;
use App\Models\Loan;
use App\Models\Borrower;
use App\Models\Message; // Import the Message model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RepaymentController extends Controller
{
    public function index()
    {
        // Fetch unread messages for the user using whereNull for read_at
        $user = Auth::user();
        $unreadMessages = $user->messages()->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        $repayments = Repayment::with(['loan', 'loan.borrower'])
            ->whereHas('loan', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        $recentRepayments = Repayment::with(['loan', 'loan.borrower'])
            ->whereHas('loan', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Pass unread messages and their count to the view
        return view('repayments.index', compact('repayments', 'recentRepayments', 'unreadMessages', 'unreadMessagesCount'));
    }

    public function create()
    {
        // Fetch unread messages for the user using whereNull for read_at
        $user = Auth::user();
        $unreadMessages = $user->messages()->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        // Get loans with a balance greater than 0
        $loans = Loan::where('user_id', Auth::id())
            ->where('balance', '>', 0)
            ->get();

        // Get borrowers associated with the current user
        $borrowers = Borrower::where('user_id', Auth::id())->get();

        // Pass unread messages and their count to the view
        return view('repayments.create', compact('loans', 'borrowers', 'unreadMessages', 'unreadMessagesCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount_paid' => 'required|numeric|min:0.01',
            'repayment_date' => 'required|date',
        ]);

        // Get the loan that the user is repaying
        $loan = Loan::where('id', $request->loan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Calculate the remaining balance
        $remainingBalance = $loan->balance - $request->amount_paid;
        $loan->balance = max($remainingBalance, 0); // Ensure balance does not go below 0

        // Set the loan status based on the balance
        if ($loan->balance == 0) {
            $loan->status = 'Paid';
        } elseif ($loan->balance > 0 && now()->greaterThan($loan->due_date)) {
            $loan->status = 'Overdue';
        } else {
            $loan->status = 'Active';
        }

        $loan->save(); // Save the updated loan

        // Create the repayment record
        Repayment::create([
            'user_id' => Auth::id(),
            'loan_id' => $loan->id,
            'amount_paid' => $request->amount_paid,
            'repayment_date' => Carbon::parse($request->repayment_date),
            'status' => 'Completed',
        ]);

        // Remove upcoming repayments if loan is fully paid
        if ($loan->balance == 0) {
            Repayment::where('loan_id', $loan->id)
                ->where('repayment_date', '>', Carbon::now())
                ->delete();
        } else {
            // Adjust upcoming repayment amount to match the remaining balance
            $upcomingRepayment = Repayment::where('loan_id', $loan->id)
                ->where('repayment_date', '>', Carbon::now())
                ->first();

            if ($upcomingRepayment) {
                $upcomingRepayment->amount_paid = min($upcomingRepayment->amount_paid, $loan->balance);
                $upcomingRepayment->save();
            }
        }

        // Redirect back to repayments with success message and unread messages
        $user = Auth::user();
        $unreadMessages = $user->messages()->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        return redirect()->route('repayments.index')->with('success', 'Repayment added successfully.')
            ->with('unreadMessages', $unreadMessages)  // Pass unread messages to the view
            ->with('unreadMessagesCount', $unreadMessagesCount);  // Pass unread messages count to the view
    }

    public function show($id)
    {
        // Fetch unread messages for the user using whereNull for read_at
        $user = Auth::user();
        $unreadMessages = $user->messages()->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        $repayment = Repayment::where('id', $id)
            ->whereHas('loan', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        // Pass unread messages and their count to the view
        return view('repayments.show', compact('repayment', 'unreadMessages', 'unreadMessagesCount'));
    }

    public function edit($id)
    {
        // Fetch unread messages for the user using whereNull for read_at
        $user = Auth::user();
        $unreadMessages = $user->messages()->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        $repayment = Repayment::where('id', $id)
            ->whereHas('loan', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $loans = Loan::where('user_id', Auth::id())->get();

        // Pass unread messages and their count to the view
        return view('repayments.edit', compact('repayment', 'loans', 'unreadMessages', 'unreadMessagesCount'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01',
            'repayment_date' => 'required|date',
        ]);

        $repayment = Repayment::where('id', $id)
            ->whereHas('loan', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $repayment->update([
            'amount_paid' => $request->amount_paid,
            'repayment_date' => Carbon::parse($request->repayment_date),
        ]);

        // Fetch unread messages for the user using whereNull for read_at
        $user = Auth::user();
        $unreadMessages = $user->messages()->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        return redirect()->route('repayments.index')->with('success', 'Repayment updated successfully.')
            ->with('unreadMessages', $unreadMessages)  // Pass unread messages to the view
            ->with('unreadMessagesCount', $unreadMessagesCount);  // Pass unread messages count to the view
    }

    public function destroy($id)
    {
        $repayment = Repayment::where('id', $id)
            ->whereHas('loan', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $repayment->delete();

        // Fetch unread messages for the user using whereNull for read_at
        $user = Auth::user();
        $unreadMessages = $user->messages()->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        return redirect()->route('repayments.index')->with('success', 'Repayment deleted successfully.')
            ->with('unreadMessages', $unreadMessages)  // Pass unread messages to the view
            ->with('unreadMessagesCount', $unreadMessagesCount);  // Pass unread messages count to the view
    }
}
