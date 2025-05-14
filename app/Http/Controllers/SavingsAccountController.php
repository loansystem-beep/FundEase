<?php

namespace App\Http\Controllers;

use App\Models\SavingsAccount;
use App\Models\Borrower;
use App\Models\SavingsProduct;
use Illuminate\Http\Request;

class SavingsAccountController extends Controller
{
    // Show the form to create a new savings account
    public function create()
    {
        // Get all borrowers and savings products for selection
        $borrowers = Borrower::all(); 
        $savingsProducts = SavingsProduct::all(); 
        
        // Return the view with data
        return view('savings-accounts.create', compact('borrowers', 'savingsProducts'));
    }

    // Store a new savings account
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'savings_product_id' => 'required|exists:savings_products,id',
            'account_number' => 'required|unique:savings_accounts',
            'balance' => 'required|numeric',
            'account_type' => 'required|in:basic,premium,business',
            'description' => 'nullable|string',
        ]);

        // Create a new savings account
        SavingsAccount::create([
            'borrower_id' => $request->borrower_id,
            'savings_product_id' => $request->savings_product_id,
            'account_number' => $request->account_number,
            'balance' => $request->balance,
            'account_type' => $request->account_type,
            'description' => $request->description,
        ]);

        // Redirect to savings accounts index with a success message
        return redirect()->route('savings-accounts.index')->with('success', 'Savings Account created successfully');
    }

    // Show the list of savings accounts
    public function index()
    {
        // Get all savings accounts with related borrower and savings product
        $savingsAccounts = SavingsAccount::with(['borrower', 'savingsProduct'])->get();
        
        // Return the view with the savings accounts data
        return view('savings-accounts.index', compact('savingsAccounts'));
    }

    // Show the form to edit a savings account
    public function edit(SavingsAccount $savingsAccount)
    {
        // Get all borrowers and savings products for selection
        $borrowers = Borrower::all(); 
        $savingsProducts = SavingsProduct::all(); 
        
        // Return the view with savings account, borrowers, and savings products data
        return view('savings-accounts.edit', compact('savingsAccount', 'borrowers', 'savingsProducts'));
    }

    // Update the savings account
    public function update(Request $request, SavingsAccount $savingsAccount)
    {
        // Validate the input data
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'savings_product_id' => 'required|exists:savings_products,id',
            'account_number' => 'required|unique:savings_accounts,account_number,' . $savingsAccount->id,
            'balance' => 'required|numeric',
            'account_type' => 'required|in:basic,premium,business',
            'description' => 'nullable|string',
        ]);

        // Update the savings account data
        $savingsAccount->update([
            'borrower_id' => $request->borrower_id,
            'savings_product_id' => $request->savings_product_id,
            'account_number' => $request->account_number,
            'balance' => $request->balance,
            'account_type' => $request->account_type,
            'description' => $request->description,
        ]);

        // Redirect to savings accounts index with a success message
        return redirect()->route('savings-accounts.index')->with('success', 'Savings Account updated successfully');
    }

    // Show the form to confirm the deletion of a savings account
    public function destroy(SavingsAccount $savingsAccount)
    {
        // Delete the savings account
        $savingsAccount->delete();

        // Redirect to savings accounts index with a success message
        return redirect()->route('savings-accounts.index')->with('success', 'Savings Account deleted successfully');
    }
}
