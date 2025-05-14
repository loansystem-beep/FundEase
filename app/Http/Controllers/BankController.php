<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;

class BankController extends Controller
{
    // Display a list of banks
    public function index()
    {
        $banks = Bank::all();
        return view('banks.index', compact('banks'));
    }

    // Show the form for creating a new bank
    public function create()
    {
        $branches = Branch::all();
        return view('banks.create', compact('branches'));
    }

    // Store a newly created bank in the database
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'code' => 'required|numeric|between:1,9999|unique:banks,code',
            'bank_account_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'currency' => 'required|string|max:3',
            'loan_categories' => 'nullable|array',
            'repayment_categories' => 'nullable|array',
            'expense_categories' => 'nullable|array',
            'income_categories' => 'nullable|array',
            'transaction_categories' => 'nullable|array',
            'branch_capital_categories' => 'nullable|array',
            'payroll_categories' => 'nullable|array',
            'branches' => 'nullable|array',
            'is_default' => 'nullable|boolean',
        ]);

        // Create the bank account
        $bank = Bank::create([
            'code' => $request->code,
            'bank_account_name' => $request->bank_account_name,
            'account_name' => $request->account_name,
            'currency' => $request->currency,
            'loan_categories' => $request->loan_categories ? json_encode($request->loan_categories) : null,
            'repayment_categories' => $request->repayment_categories ? json_encode($request->repayment_categories) : null,
            'expense_categories' => $request->expense_categories ? json_encode($request->expense_categories) : null,
            'income_categories' => $request->income_categories ? json_encode($request->income_categories) : null,
            'transaction_categories' => $request->transaction_categories ? json_encode($request->transaction_categories) : null,
            'branch_capital_categories' => $request->branch_capital_categories ? json_encode($request->branch_capital_categories) : null,
            'payroll_categories' => $request->payroll_categories ? json_encode($request->payroll_categories) : null,
            'branches' => $request->branches ? json_encode($request->branches) : null,
            'is_default' => $request->is_default ?? false,
        ]);

        // Attach selected branches to the bank
        if ($request->branches) {
            $bank->branches()->sync($request->branches);
        }

        return redirect()->route('banks.index')
                         ->with('success', 'Bank account created successfully!');
    }

    // Show the form for editing the specified bank
    public function edit(Bank $bank)
    {
        $branches = Branch::all();
        return view('banks.edit', compact('bank', 'branches'));
    }

    // Update the specified bank in the database
    public function update(Request $request, Bank $bank)
    {
        // Validate the incoming request
        $request->validate([
            'code' => 'required|numeric|between:1,9999|unique:banks,code,' . $bank->id,
            'bank_account_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'currency' => 'required|string|max:3',
            'loan_categories' => 'nullable|array',
            'repayment_categories' => 'nullable|array',
            'expense_categories' => 'nullable|array',
            'income_categories' => 'nullable|array',
            'transaction_categories' => 'nullable|array',
            'branch_capital_categories' => 'nullable|array',
            'payroll_categories' => 'nullable|array',
            'branches' => 'nullable|array',
            'is_default' => 'nullable|boolean',
        ]);

        // Update the bank account
        $bank->update([
            'code' => $request->code,
            'bank_account_name' => $request->bank_account_name,
            'account_name' => $request->account_name,
            'currency' => $request->currency,
            'loan_categories' => $request->loan_categories ? json_encode($request->loan_categories) : null,
            'repayment_categories' => $request->repayment_categories ? json_encode($request->repayment_categories) : null,
            'expense_categories' => $request->expense_categories ? json_encode($request->expense_categories) : null,
            'income_categories' => $request->income_categories ? json_encode($request->income_categories) : null,
            'transaction_categories' => $request->transaction_categories ? json_encode($request->transaction_categories) : null,
            'branch_capital_categories' => $request->branch_capital_categories ? json_encode($request->branch_capital_categories) : null,
            'payroll_categories' => $request->payroll_categories ? json_encode($request->payroll_categories) : null,
            'branches' => $request->branches ? json_encode($request->branches) : null,
            'is_default' => $request->is_default ?? false,
        ]);

        // Attach selected branches to the bank
        if ($request->branches) {
            $bank->branches()->sync($request->branches);
        }

        return redirect()->route('banks.index')
                         ->with('success', 'Bank account updated successfully!');
    }

    // Display the specified bank
    public function show(Bank $bank)
    {
        return view('banks.show', compact('bank'));
    }

    // Remove the specified bank from the database
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('banks.index')
                         ->with('success', 'Bank account deleted successfully!');
    }
}
