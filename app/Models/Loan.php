<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_title',
        'description',
        'loan_product_id',
        'borrower_id',
        'loan_number',
        'is_custom_loan_number',
        'loan_status_id',
        'disbursed_by_id',
        'principal_amount',
        'loan_release_date',
        'interest_method',
        'interest_type',
        'interest_rate',
        'interest_period',
        'loan_duration_value',
        'loan_duration_type',
        'repayment_cycle_id',
        'number_of_repayments',

        // New schedule fields
        'decimal_places',
        'round_up_off_interest',
        'interest_start_date',
        'first_repayment_date',
        'pro_rata_first_repayment',
        'adjust_fees_first_repayment',
        'do_not_adjust_remaining_repayments',
        'first_repayment_amount',
        'last_repayment_amount',
        'override_maturity_date',
        'override_each_repayment_amount',
        'calculate_interest_pro_rata',
        'interest_charge_method',
        'skip_interest_first_n_repayments',
        'principal_charge_method',
        'skip_principal_first_n_repayments',
        'skip_principal_until_date',
        'balloon_repayment_amount',
        'move_first_repayment_days',

        // Existing fields
        'automatic_payments',
        'automatic_payment_start_time',
        'automatic_payment_end_time',
        'payment_method',
        'bank_account_id',
        'fee_id',
        'deductible_fee_id',
        'non_deductible_fee_id',
        'custom_fields',
        'extend_loan_after_maturity',
        'after_maturity_interest_type',
        'after_maturity_interest_rate',
        'after_maturity_interest_period',
        'after_maturity_number_of_repayments',
        'include_fees_after_maturity',
        'keep_status_as_past_maturity',
        'apply_to_date',
        'calculated_interest',
    ];

    protected $casts = [
        'custom_fields'                         => 'array',
        'automatic_payments'                    => 'boolean',
        'round_up_off_interest'                 => 'boolean',
        'pro_rata_first_repayment'              => 'boolean',
        'adjust_fees_first_repayment'           => 'boolean',
        'do_not_adjust_remaining_repayments'    => 'boolean',
        'calculate_interest_pro_rata'           => 'boolean',
        'extend_loan_after_maturity'            => 'boolean',
        'include_fees_after_maturity'           => 'boolean',
        'keep_status_as_past_maturity'          => 'boolean',
        'is_custom_loan_number'                 => 'boolean',
        'loan_release_date'                     => 'date',
        'interest_start_date'                   => 'date',
        'first_repayment_date'                  => 'date',
        'override_maturity_date'                => 'date',
        'apply_to_date'                         => 'date',
        'skip_principal_until_date'             => 'date',
        'automatic_payment_start_time'          => 'datetime',
        'automatic_payment_end_time'            => 'datetime',

        'calculated_interest'                   => 'float',
        'principal_amount'                      => 'float',
        'interest_rate'                         => 'float',
        'first_repayment_amount'                => 'float',
        'last_repayment_amount'                 => 'float',
        'override_each_repayment_amount'        => 'float',
        'balloon_repayment_amount'              => 'float',

        'decimal_places'                        => 'integer',
        'skip_interest_first_n_repayments'      => 'integer',
        'skip_principal_first_n_repayments'     => 'integer',
        'move_first_repayment_days'             => 'integer',
    ];

    // Relationships
    public function loanProduct()
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id');
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'borrower_id');
    }

    public function loanStatus()
    {
        return $this->belongsTo(LoanStatus::class, 'loan_status_id');
    }

    public function disburser()
    {
        return $this->belongsTo(BankAccount::class, 'disbursed_by_id');
    }

    public function repaymentCycle()
    {
        return $this->belongsTo(RepaymentCycle::class, 'repayment_cycle_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }

    public function deductibleFee()
    {
        return $this->belongsTo(Fee::class, 'deductible_fee_id');
    }

    public function nonDeductibleFee()
    {
        return $this->belongsTo(Fee::class, 'non_deductible_fee_id');
    }

    public function loanFiles()
    {
        return $this->hasMany(LoanFile::class);
    }

    public function guarantors()
    {
        return $this->belongsToMany(User::class, 'guarantor_loan', 'loan_id', 'guarantor_id');
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    /**
     * Calculate and set the interest amount for the loan based on the selected interest method.
     */
    public function calculateInterest()
    {
        switch ($this->interest_method) {
            case 'flat':
                $this->calculated_interest = $this->principal_amount * ($this->interest_rate / 100);
                break;

            case 'reducing_balance_equal_installment':
                $this->calculated_interest = ($this->principal_amount * ($this->interest_rate / 100)) / max($this->number_of_repayments, 1);
                break;

            case 'reducing_balance_equal_principal':
                $this->calculated_interest = ($this->principal_amount * ($this->interest_rate / 100)) / max($this->loan_duration_value, 1);
                break;

            case 'interest_only':
                $this->calculated_interest = $this->principal_amount * ($this->interest_rate / 100);
                break;

            case 'compound_accrued':
            case 'compound_equal_installment':
                $rate     = ($this->interest_rate / 100);
                $duration = $this->loan_duration_value;
                $this->calculated_interest = $this->principal_amount * pow(1 + $rate, $duration) - $this->principal_amount;
                break;

            default:
                $this->calculated_interest = 0;
        }

        $this->save();
    }

    /**
     * Ensure the 'principal_charge_method' is valid.
     */
    public static function validatePrincipalChargeMethod($value)
    {
        $validMethods = [
            'normal',
            'released_date',
            'first_repayment',
            'last_repayment',
            'do_not_charge_last_repayment',
            'do_not_charge_first_n_days'
        ];

        return in_array($value, $validMethods);
    }
}
