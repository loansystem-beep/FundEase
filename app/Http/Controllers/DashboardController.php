<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Loan;
use App\Models\Repayment;
use App\Models\Message;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->is_admin) {
            // Optional admin logic
        }

        $loanQuery = Loan::where('user_id', $user->id);

        if ($request->filled('status')) {
            match ($request->status) {
                'active' => $loanQuery->where('status', 'active'),
                'overdue' => $loanQuery->where('status', 'overdue'),
                'paid' => $loanQuery->where('status', 'paid'),
                default => null,
            };
        }

        $totalBorrowers = Borrower::where('user_id', $user->id)->count();
        $totalLoanAmount = $loanQuery->sum('amount');
        $amountPaid = Repayment::whereHas('loan', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('amount_paid');

        $remainingBalance = $totalLoanAmount - $amountPaid;
        $activeBorrowers = Borrower::where('user_id', $user->id)->where('status', 'active')->count();
        $totalLoans = $loanQuery->count();
        $defaulters = Borrower::where('user_id', $user->id)->whereHas('loans', function ($query) {
            $query->where('status', 'defaulted');
        })->count();

        $borrowers = Borrower::where('user_id', $user->id)
            ->with('loans')
            ->when($request->filled('borrower_type'), function ($query) use ($request) {
                return $query->where('borrower_type', $request->borrower_type);
            })
            ->latest()
            ->take(5)
            ->get();

        $recentRepayments = Repayment::with(['loan.borrower'])
            ->whereHas('loan', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();

        $upcomingPayments = Loan::where('user_id', $user->id)
            ->where('balance', '>', 0)
            ->whereBetween('due_date', [Carbon::today(), Carbon::today()->addDays(7)])
            ->with('borrower')
            ->get();

        $borrowers->each(function ($borrower) {
            $borrower->created_at = Carbon::parse($borrower->created_at)->format('Y-m-d');
        });

        // ✅ Fixed unread message query
        $unreadMessages = Message::where('user_id', $user->id)->whereNull('read_at')->get();
        $unreadMessagesCount = $unreadMessages->count();

        $expiresAt = Carbon::parse($user->expires_at);
        $isExpired = $expiresAt->isPast();

        if ($isExpired) {
            $remainingTime = 'Your account has expired. Please contact support to reactivate your account.';
        } else {
            $remainingTime = $expiresAt->diffForHumans(null, true);
        }

        return view('dashboard', compact(
            'user',
            'totalBorrowers',
            'totalLoanAmount',
            'amountPaid',
            'remainingBalance',
            'activeBorrowers',
            'defaulters',
            'totalLoans',
            'recentRepayments',
            'upcomingPayments',
            'borrowers',
            'unreadMessages',
            'unreadMessagesCount',
            'remainingTime',
            'isExpired'
        ));
    }
}
