<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoanCalculatorService;

class LoanCalculatorController extends Controller
{
    protected $calculator;

    public function __construct(LoanCalculatorService $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Handles AJAX loan preview generation.
     */
    public function preview(Request $request)
    {
        $data = $request->validate([
            'principal_amount' => 'required|numeric',
            'interest_method' => 'required|string',
            'interest_type' => 'required|string',
            'interest_rate' => 'required|numeric',
            'interest_period' => 'required|string',
            'loan_duration_value' => 'required|numeric',
            'loan_duration_type' => 'required|string',
            'repayment_cycle_id' => 'required|integer',
            'number_of_repayments' => 'required|integer',
            'interest_start_date' => 'required|date',
            'first_repayment_date' => 'required|date',

            // Optional advanced fields
            'decimal_places' => 'nullable|integer',
            'round_up_off_interest' => 'nullable|boolean',
            'calculate_interest_pro_rata' => 'nullable|boolean',
            'interest_charge_method' => 'nullable|string',
            'principal_charge_method' => 'nullable|string',
            'balloon_repayment_amount' => 'nullable|numeric',
            'move_first_repayment_days' => 'nullable|integer',
            'override_maturity_date' => 'nullable|date',
            'override_each_repayment_amount' => 'nullable|numeric',
        ]);

        try {
            $result = $this->calculator->preview($data);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Loan preview failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
