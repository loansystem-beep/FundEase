<?php

namespace App\Http\Controllers;

use App\Models\SavingsTransaction;
use App\Models\SavingsAccount;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingsTransactionController extends Controller
{
    public function index()
    {
        // Fetch transactions along with their related savings account and borrower
        $transactions = SavingsTransaction::with(['savingsAccount', 'borrower'])
                                          ->latest()
                                          ->paginate(20);

        return view('savings-transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Fetch all savings accounts and borrowers
        $accounts = SavingsAccount::all();
        $borrowers = Borrower::all(); // Fetch borrowers for selection
        return view('savings-transactions.create', compact('accounts', 'borrowers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'savings_account_id' => 'required|exists:savings_accounts,id',
            'borrower_id'        => 'required|exists:borrowers,id', // Validate borrower ID
            'action'             => 'required|string|max:255',
            'account_number'     => 'required|string|max:255',
            'ledger_balance'     => 'required|numeric',
            'transaction_date'   => 'required|date',
            'type'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'debit'              => 'nullable|numeric',
            'credit'             => 'nullable|numeric',
            'receipt'            => 'nullable|string|max:255',
        ]);

        // Fetch the borrower details to store first and last names
        $borrower = Borrower::find($request->borrower_id);

        // Create the savings transaction, including borrower details
        SavingsTransaction::create([
            'savings_account_id' => $request->savings_account_id,
            'borrower_id'        => $request->borrower_id,
            'borrower_first_name'=> $borrower->first_name,  // Store first name
            'borrower_last_name' => $borrower->last_name,   // Store last name
            'action'             => $request->action,
            'account_number'     => $request->account_number,
            'ledger_balance'     => $request->ledger_balance,
            'transaction_date'   => $request->transaction_date,
            'type'               => $request->type,
            'description'        => $request->description,
            'debit'              => $request->debit ?? 0,
            'credit'             => $request->credit ?? 0,
            'receipt'            => $request->receipt,
        ]);

        return redirect()->route('savings-transactions.index')->with('success', 'Transaction recorded successfully.');
    }

    public function show(SavingsTransaction $savingsTransaction)
    {
        // Show transaction along with associated borrower and savings account
        return view('savings-transactions.show', compact('savingsTransaction'));
    }
}
