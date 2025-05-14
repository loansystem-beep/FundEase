<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BankAccount;
use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanProductController extends Controller
{
    /**
     * Display a listing of the loan products.
     */
    public function index()
    {
        $loanProducts = LoanProduct::with('branch')->latest()->get();
        return view('loanProducts.index', compact('loanProducts'));
    }

    /**
     * Show the form for creating a new loan product.
     */
    public function create()
    {
        $branches     = Branch::all();
        $bankAccounts = BankAccount::all();

        return view('loanProducts.create', compact('branches', 'bankAccounts'));
    }

    /**
     * Store a newly created loan product in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'unique_id'                           => 'required|string|max:255|unique:loan_products',
            'name'                                => 'required|string|max:255',
            'short_name'                          => 'nullable|string|max:100',
            'description'                         => 'nullable|string|max:1000',
            'branch_access'                       => 'nullable|array',
            'branch_access.*'                     => 'exists:branches,id',
            'branch_id'                           => 'nullable|exists:branches,id',
            'minimum_principal_amount'            => 'nullable|numeric',
            'default_principal_amount'            => 'nullable|numeric',
            'maximum_principal_amount'            => 'nullable|numeric',
            'disbursed_by'                        => 'nullable|in:Cash,Cheque,Wire Transfer,Online Transfer',
            'loan_release_date'                   => 'nullable|date',
            'interest_method'                     => 'nullable|string',
            'interest_type'                       => 'nullable|string',
            'is_interest_percentage'              => 'nullable|boolean',
            'interest_period'                     => 'nullable|string',
            'minimum_interest'                    => 'nullable|numeric',
            'default_interest'                    => 'nullable|numeric',
            'maximum_interest'                    => 'nullable|numeric',
            'loan_duration_period'                => 'nullable|string',
            'minimum_loan_duration'               => 'nullable|numeric',
            'default_loan_duration'               => 'nullable|numeric',
            'maximum_loan_duration'               => 'nullable|numeric',
            'repayment_cycle'                     => 'nullable|string',
            'minimum_number_of_repayments'        => 'nullable|numeric',
            'default_number_of_repayments'        => 'nullable|numeric',
            'maximum_number_of_repayments'        => 'nullable|numeric',
            'repayment_order'                     => 'nullable|array',
            'repayment_order.*'                   => 'in:penalty,fees,interest,principal',
            'auto_payments_enabled'               => 'nullable|boolean',
            'start_time'                          => 'nullable|string',
            'end_time'                            => 'nullable|string',
            'payment_method'                      => 'nullable|in:cash,bank',
            'bank_account_id'                     => 'nullable|exists:bank_accounts,id',
            'extend_after_maturity'               => 'nullable|boolean',
            'interest_type_after_maturity'        => 'nullable|in:percentage,fixed',
            'interest_rate_after_maturity'        => 'nullable|numeric',
            'number_of_repayments_after_maturity' => 'nullable|numeric',
            'include_fees_after_maturity'         => 'nullable|boolean',
            'keep_past_maturity_status'           => 'nullable|boolean',
            'auto_set_release_date_today'         => 'nullable|boolean',
        ]);

        // Handle checkbox booleans
        $validated['auto_payments_enabled']       = $request->has('auto_payments_enabled');
        $validated['extend_after_maturity']       = $request->has('extend_after_maturity');
        $validated['include_fees_after_maturity'] = $request->has('include_fees_after_maturity');
        $validated['keep_past_maturity_status']   = $request->has('keep_past_maturity_status');
        $validated['auto_set_release_date_today'] = $request->has('auto_set_release_date_today');

        // If "set release date to today" is checked
        if ($validated['auto_set_release_date_today']) {
            $validated['loan_release_date'] = Carbon::today()->toDateString();
        }

        // **Convert any time input into 24-hour MySQL format (HH:MM:SS)**
        if (!empty($validated['start_time'])) {
            $validated['start_time'] = Carbon::parse($validated['start_time'])
                ->format('H:i:s');
        }
        if (!empty($validated['end_time'])) {
            $validated['end_time'] = Carbon::parse($validated['end_time'])
                ->format('H:i:s');
        }

        // JSON-encode arrays
        $validated['branch_access']   = isset($validated['branch_access'])
            ? json_encode($validated['branch_access'])
            : null;
        $validated['repayment_order'] = isset($validated['repayment_order'])
            ? json_encode($validated['repayment_order'])
            : null;

        LoanProduct::create($validated);

        return redirect()
            ->route('loanProducts.index')
            ->with('success', 'Loan product created.');
    }

    /**
     * Display the specified loan product.
     */
    public function show(LoanProduct $loanProduct)
    {
        return view('loanProducts.show', compact('loanProduct'));
    }

    /**
     * Show the form for editing the specified loan product.
     */
    public function edit(LoanProduct $loanProduct)
    {
        $branches     = Branch::all();
        $bankAccounts = BankAccount::all();

        return view('loanProducts.edit', compact('loanProduct', 'branches', 'bankAccounts'));
    }

    /**
     * Update the specified loan product in storage.
     */
    public function update(Request $request, LoanProduct $loanProduct)
    {
        // Validate the request data
        $validated = $request->validate([
            'unique_id'                             => 'required|string|max:255|unique:loan_products,unique_id,' . $loanProduct->id,
            'name'                                  => 'required|string|max:255',
            'short_name'                            => 'nullable|string|max:100',
            'description'                           => 'nullable|string|max:1000',
            'branch_access'                         => 'nullable|array',
            'branch_access.*'                       => 'exists:branches,id',
            'branch_id'                             => 'nullable|exists:branches,id',
            'minimum_principal_amount'              => 'nullable|numeric',
            'default_principal_amount'              => 'nullable|numeric',
            'maximum_principal_amount'              => 'nullable|numeric',
            'disbursed_by'                          => 'nullable|in:Cash,Cheque,Wire Transfer,Online Transfer',
            'loan_release_date'                     => 'nullable|date',
            'interest_method'                       => 'nullable|string',
            'interest_type'                         => 'nullable|string',
            'is_interest_percentage'                => 'nullable|boolean',
            'interest_period'                       => 'nullable|string',
            'minimum_interest'                      => 'nullable|numeric',
            'default_interest'                      => 'nullable|numeric',
            'maximum_interest'                      => 'nullable|numeric',
            'loan_duration_period'                  => 'nullable|string',
            'minimum_loan_duration'                 => 'nullable|numeric',
            'default_loan_duration'                 => 'nullable|numeric',
            'maximum_loan_duration'                 => 'nullable|numeric',
            'repayment_cycle'                       => 'nullable|string',
            'minimum_number_of_repayments'          => 'nullable|numeric',
            'default_number_of_repayments'          => 'nullable|numeric',
            'maximum_number_of_repayments'          => 'nullable|numeric',
            'repayment_order'                       => 'nullable|array',
            'repayment_order.*'                     => 'in:penalty,fees,interest,principal',
            'auto_payments_enabled'                 => 'nullable|boolean',
            'start_time'                            => 'nullable|string',
            'end_time'                              => 'nullable|string',
            'payment_method'                        => 'nullable|in:cash,bank',
            'bank_account_id'                       => 'nullable|exists:bank_accounts,id',
            'extend_after_maturity'                 => 'nullable|boolean',
            'interest_type_after_maturity'          => 'nullable|in:percentage,fixed',
            'interest_rate_after_maturity'          => 'nullable|numeric',
            'number_of_repayments_after_maturity'   => 'nullable|numeric',
            'include_fees_after_maturity'           => 'nullable|boolean',
            'keep_past_maturity_status'             => 'nullable|boolean',
            'auto_set_release_date_today'           => 'nullable|boolean',
        ]);

        // Handle checkboxes
        $validated['auto_payments_enabled']       = $request->has('auto_payments_enabled');
        $validated['extend_after_maturity']       = $request->has('extend_after_maturity');
        $validated['include_fees_after_maturity'] = $request->has('include_fees_after_maturity');
        $validated['keep_past_maturity_status']   = $request->has('keep_past_maturity_status');
        $validated['auto_set_release_date_today'] = $request->has('auto_set_release_date_today');

        // Auto‐set release date if requested
        if ($validated['auto_set_release_date_today']) {
            $validated['loan_release_date'] = Carbon::today()->toDateString();
        }

        // **Always convert times to HH:MM:SS format**
        if (!empty($validated['start_time'])) {
            $validated['start_time'] = Carbon::parse($validated['start_time'])
                ->format('H:i:s');
        }
        if (!empty($validated['end_time'])) {
            $validated['end_time'] = Carbon::parse($validated['end_time'])
                ->format('H:i:s');
        }

        // JSON‐encode selects
        $validated['branch_access']   = isset($validated['branch_access'])
            ? json_encode($validated['branch_access'])
            : null;
        $validated['repayment_order'] = isset($validated['repayment_order'])
            ? json_encode($validated['repayment_order'])
            : null;

        $loanProduct->update($validated);

        return redirect()
            ->route('loanProducts.index')
            ->with('success', 'Loan product updated.');
    }

    /**
     * Remove the specified loan product from storage.
     */
    public function destroy(LoanProduct $loanProduct)
    {
        $loanProduct->delete();
        return redirect()
            ->route('loanProducts.index')
            ->with('success', 'Loan product deleted.');
    }
}
