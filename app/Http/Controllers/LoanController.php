<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Borrower;
use App\Models\LoanStatus;
use App\Models\BankAccount;
use App\Models\RepaymentCycle;
use App\Models\Guarantor;
use App\Models\Fee;
use App\Services\LoanCalculatorService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('borrower', 'loanProduct', 'loanStatus')->paginate(15);
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        return view('loans.create', [
            'loan'             => new Loan(),
            'loanProducts'     => LoanProduct::all(),
            'borrowers'        => Borrower::orderBy('first_name')->orderBy('last_name')->get(),
            'loanStatuses'     => LoanStatus::all(),
            'bankAccounts'     => BankAccount::all(),
            'repaymentCycles'  => RepaymentCycle::all(),
            'guarantors'       => Guarantor::all(),
            'fees'             => Fee::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_product_id'             => 'required|exists:loan_products,id',
            'borrower_id'                 => 'required|exists:borrowers,id',
            'loan_number'                 => 'required|string|unique:loans,loan_number',
            'disbursed_by_id'             => 'required|exists:bank_accounts,id',
            'principal_amount'            => 'required|numeric|min:0',
            'loan_release_date'           => 'required|date',
            'interest_method'             => 'required|string|in:flat,reducing_balance_equal_installment,reducing_balance_equal_principal,interest_only,compound_accrued,compound_equal_installment',
            'interest_type'               => 'required|string|in:percentage,fixed',
            'interest_rate'               => 'required|numeric|min:0',
            'interest_period'             => 'required|string|in:weekly,monthly,yearly',
            'loan_duration_value'         => 'required|integer|min:1',
            'loan_duration_type'          => 'required|string|in:days,weeks,months,years',
            'repayment_cycle_id'          => 'required|exists:repayment_cycles,id',
            'number_of_repayments'        => 'required|integer|min:1',
            'decimal_places'              => 'required|integer|min:0|max:6',
            'interest_start_date'         => 'required|date',
            'first_repayment_date'        => 'required|date',
            'first_repayment_amount'      => 'nullable|numeric|min:0',
            'last_repayment_amount'       => 'nullable|numeric|min:0',
            'principal_charge_method'     => 'nullable|string|in:normal,released_date,first_repayment,last_repayment,do_not_charge_last_repayment,do_not_charge_first_n_days',
            'interest_charge_method'      => 'nullable|string|in:normal,balloon',
            'balloon_repayment_amount'    => 'nullable|numeric|min:0',
            'move_first_repayment_days'   => 'nullable|integer|min:0',
            'guarantors'                  => 'nullable|array',
            'guarantors.*'                => 'exists:guarantors,id',
        ]);

        // Merge defaults and validated input
        $data = array_merge([
            'interest_method'             => 'flat',
            'interest_type'               => 'percentage',
            'interest_period'             => 'monthly',
            'decimal_places'              => 2,
            'principal_charge_method'     => 'normal',
        ], $validated);

        // If the "Do Not Charge Principal on First N Days" is selected, validate and process it
        if ($request->has('principal_charge_method') && $request->input('principal_charge_method') == 'do_not_charge_first_n_days') {
            $data['move_first_repayment_days'] = $request->input('move_first_repayment_days', 0); // Default to 0 if not provided
        }

        // Create the loan
        $loan = Loan::create($data);

        // Sync guarantors if any
        if (! empty($data['guarantors'])) {
            $loan->guarantors()->sync($data['guarantors']);
        }

        // Calculate the interest based on the provided loan data
        $loan->calculateInterest();

        // Redirect to loan index with success message
        return redirect()
            ->route('loans.index')
            ->with('success', 'Loan created successfully.');
    }

    public function show(Loan $loan)
    {
        $loan->load([
            'borrower',
            'loanProduct',
            'loanStatus',
            'repaymentCycle',
            'bankAccount',
            'guarantors',
            'loanFiles',
            'repayments',
        ]);

        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        return view('loans.edit', [
            'loan'             => $loan->load('guarantors'),
            'loanProducts'     => LoanProduct::all(),
            'borrowers'        => Borrower::orderBy('first_name')->orderBy('last_name')->get(),
            'loanStatuses'     => LoanStatus::all(),
            'bankAccounts'     => BankAccount::all(),
            'repaymentCycles'  => RepaymentCycle::all(),
            'guarantors'       => Guarantor::all(),
            'fees'             => Fee::all(),
        ]);
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'loan_product_id'             => 'required|exists:loan_products,id',
            'borrower_id'                 => 'required|exists:borrowers,id',
            'loan_number'                 => 'required|string|unique:loans,loan_number,' . $loan->id,
            'disbursed_by_id'             => 'required|exists:bank_accounts,id',
            'principal_amount'            => 'required|numeric|min:0',
            'loan_release_date'           => 'required|date',
            'interest_method'             => 'required|string|in:flat,reducing_balance_equal_installment,reducing_balance_equal_principal,interest_only,compound_accrued,compound_equal_installment',
            'interest_type'               => 'required|string|in:percentage,fixed',
            'interest_rate'               => 'required|numeric|min:0',
            'interest_period'             => 'required|string|in:weekly,monthly,yearly',
            'loan_duration_value'         => 'required|integer|min:1',
            'loan_duration_type'          => 'required|string|in:days,weeks,months,years',
            'repayment_cycle_id'          => 'required|exists:repayment_cycles,id',
            'number_of_repayments'        => 'required|integer|min:1',
            'decimal_places'              => 'required|integer|min:0|max:6',
            'interest_start_date'         => 'required|date',
            'first_repayment_date'        => 'required|date',
            'first_repayment_amount'      => 'nullable|numeric|min:0',
            'last_repayment_amount'       => 'nullable|numeric|min:0',
            'principal_charge_method'     => 'nullable|string|in:normal,released_date,first_repayment,last_repayment,do_not_charge_last_repayment,do_not_charge_first_n_days',
            'interest_charge_method'      => 'nullable|string|in:normal,balloon',
            'balloon_repayment_amount'    => 'nullable|numeric|min:0',
            'move_first_repayment_days'   => 'nullable|integer|min:0',
            'guarantors'                  => 'nullable|array',
            'guarantors.*'                => 'exists:guarantors,id',
        ]);

        // Update the loan with the validated data
        $loan->update($validated);

        // Sync guarantors if any
        if (! empty($validated['guarantors'])) {
            $loan->guarantors()->sync($validated['guarantors']);
        }

        // Recalculate interest if necessary
        $loan->calculateInterest();

        // Redirect to loan show page with success message
        return redirect()
            ->route('loans.show', $loan)
            ->with('success', 'Loan updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        $loan->guarantors()->detach();
        $loan->delete();

        return redirect()
            ->route('loans.index')
            ->with('success', 'Loan deleted successfully.');
    }

    public function previewCalculation(Request $request)
    {
        $v = $request->validate([
            'principal'       => 'required|numeric|min:0',
            'interest_rate'   => 'required|numeric|min:0',
            'term'            => 'required|integer|min:1',
            'interest_method' => 'required|string|in:flat,reducing_balance_equal_installment,reducing_balance_equal_principal,interest_only,compound_accrued,compound_equal_installment',
            'interest_type'   => 'nullable|string|in:percentage,fixed',
            'interest_period' => 'nullable|string|in:weekly,monthly,yearly',
        ]);

        $calc = new LoanCalculatorService(
            $v['principal'],
            $v['interest_rate'],
            $v['term'],
            $v['interest_method'],
            $v['interest_period'] ?? 'monthly',
            $v['interest_type'] ?? null
        );

        return response()->json($calc->calculate());
    }
}
