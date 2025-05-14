<?php

// config/loan_calculator.php

return [
    // Core inputs
    'principal' => 100000, // Example principal amount
    'rate' => 10, // Annual interest rate in percentage (e.g., 10 for 10%)
    'term' => 12, // Loan term in months (e.g., 12 months)
    'method' => 'flat', // Loan method (e.g., flat, reducing_installment, etc.)
    'period' => 'monthly', // Repayment period (e.g., monthly, weekly, yearly)
    'type' => 'percentage', // Interest type (e.g., percentage or fixed)

    // Optional schedule overrides
    'decimal_places' => 2, // Decimal places for the repayment schedule
    'round_up_off_interest' => false, // If true, interest will be rounded up
    'interest_start_date' => '2025-06-01', // Example date when interest starts
    'first_repayment_date' => '2025-07-01', // Example first repayment date
    'pro_rata_first_repayment' => true, // If true, the first repayment is pro-rata
    'adjust_fees_first_repayment' => true, // If true, fees will be adjusted first repayment
    'do_not_adjust_remaining_repayments' => false, // If true, remaining repayments will not be adjusted
    'first_repayment_amount' => null, // Fixed amount for the first repayment (if any)
    'last_repayment_amount' => null, // Fixed amount for the last repayment (if any)
    'override_maturity_date' => null, // Override the maturity date (if any)
    'override_each_repayment_amount' => null, // Override the amount for each repayment (if any)
    'calculate_interest_pro_rata' => false, // If true, interest will be calculated pro-rata
    'interest_charge_method' => 'normal', // Method for calculating interest
    'skip_interest_first_n_repayments' => 0, // Number of repayments to skip interest
    'principal_charge_method' => 'normal', // Method for charging principal (e.g., flat or reducing)
    'skip_principal_first_n_repayments' => 0, // Number of repayments to skip principal
    'skip_principal_until_date' => null, // Skip principal repayments until a certain date
    'balloon_repayment_amount' => null, // Balloon repayment amount (if any) to add at the end
    'move_first_repayment_days' => 0, // Number of days to move the first repayment
];
