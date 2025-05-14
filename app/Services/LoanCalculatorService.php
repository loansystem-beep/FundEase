<?php

namespace App\Services;

use Carbon\Carbon;

class LoanCalculatorService
{
    // Core inputs
    protected float   $principal;
    protected float   $annualRate;   // decimal (e.g. 0.05 for 5%)
    protected int     $term;         // number of installments
    protected string  $method;       // flat, reducing_installment, etc.
    protected string  $period;       // weekly|monthly|yearly
    protected ?string $type;         // percentage|fixed (for flat)

    // New schedule options
    protected int             $decimalPlaces;
    protected bool            $roundUpInterest;
    protected ?Carbon         $interestStartDate;
    protected ?Carbon         $firstRepaymentDate;
    protected bool            $proRataFirst;
    protected bool            $adjustFeesFirst;
    protected bool            $freezeRemaining;
    protected ?float          $firstRepaymentAmount;
    protected ?float          $lastRepaymentAmount;
    protected ?Carbon         $overrideMaturityDate;
    protected ?float          $overrideEachRepayment;
    protected bool            $proRataEach;
    protected string          $interestChargeMethod;
    protected ?int            $skipInterestFirstN;
    protected string          $principalChargeMethod;
    protected ?int            $skipPrincipalFirstN;
    protected ?Carbon         $skipPrincipalUntilDate;
    protected ?float          $balloonAmount;
    protected ?int            $moveFirstDays;

    public function __construct(array $config)
    {
        // Required
        $this->principal  = $config['principal'];
        $this->annualRate = $config['rate']/100;
        $this->term       = $config['term'];
        $this->method     = $config['method'];
        $this->period     = $config['period']    ?? 'monthly';
        $this->type       = $config['type']      ?? null;

        // Optional schedule overrides
        $this->decimalPlaces             = $config['decimal_places'] ?? 2;
        $this->roundUpInterest           = $config['round_up_off_interest'] ?? false;
        $this->interestStartDate         = isset($config['interest_start_date'])
            ? Carbon::parse($config['interest_start_date'])
            : null;
        $this->firstRepaymentDate        = isset($config['first_repayment_date'])
            ? Carbon::parse($config['first_repayment_date'])
            : null;
        $this->proRataFirst              = $config['pro_rata_first_repayment'] ?? false;
        $this->adjustFeesFirst           = $config['adjust_fees_first_repayment'] ?? false;
        $this->freezeRemaining           = $config['do_not_adjust_remaining_repayments'] ?? false;
        $this->firstRepaymentAmount      = $config['first_repayment_amount'] ?? null;
        $this->lastRepaymentAmount       = $config['last_repayment_amount']  ?? null;
        $this->overrideMaturityDate      = isset($config['override_maturity_date'])
            ? Carbon::parse($config['override_maturity_date'])
            : null;
        $this->overrideEachRepayment     = $config['override_each_repayment_amount'] ?? null;
        $this->proRataEach               = $config['calculate_interest_pro_rata'] ?? false;
        $this->interestChargeMethod      = $config['interest_charge_method'] ?? 'normal';
        $this->skipInterestFirstN        = $config['skip_interest_first_n_repayments'] ?? 0;
        $this->principalChargeMethod     = $config['principal_charge_method'] ?? 'normal';
        $this->skipPrincipalFirstN       = $config['skip_principal_first_n_repayments'] ?? 0;
        $this->skipPrincipalUntilDate    = isset($config['skip_principal_until_date'])
            ? Carbon::parse($config['skip_principal_until_date'])
            : null;
        $this->balloonAmount             = $config['balloon_repayment_amount'] ?? null;
        $this->moveFirstDays             = $config['move_first_repayment_days'] ?? 0;
    }

    /**
     * Generate the detailed repayment schedule.
     * Returns array of installments: [ ['date'=>..., 'principal'=>..., 'interest'=>..., 'total'=>...] , ... ]
     */
    public function calculate(): array
    {
        // 1. Determine base dates
        $startDate = $this->interestStartDate ?: now();
        $firstDate = $this->firstRepaymentDate
            ?? $startDate->copy()->add($this->period, 1);

        // 2. Possibly shift first repayment if too soon
        if ($this->moveFirstDays > 0 &&
            $firstDate->diffInDays($startDate) < $this->moveFirstDays) {
            $firstDate->add($this->period, 1);
        }

        // 3. Build equal-dated schedule
        $schedule = [];
        $date = $firstDate->copy();
        for ($i = 1; $i <= $this->term; $i++) {
            $schedule[$i] = [
                'date' => $date->toDateString(),
                'principal' => 0.0,
                'interest'  => 0.0,
            ];
            $date->add($this->period, 1);
        }

        // 4. Apply flat or amortization logic to fill base principal+interest
        //    (You’d call your existing calculateFlat(), calculateReducingInstallment(), etc.
        //     then distribute results across $schedule[$i]['principal']/$schedule[$i]['interest'].)

        // ... (omitted: amortization distribution logic) ...

        // 5. Insert overrides & pro-rata first installment
        if ($this->proRataFirst) {
            // calculate days between startDate and firstDate, etc.
            // adjust $schedule[1]['interest'] accordingly
        }
        if ($this->firstRepaymentAmount !== null) {
            $schedule[1]['principal'] = min($schedule[1]['principal'], $this->firstRepaymentAmount);
        }
        if ($this->lastRepaymentAmount !== null) {
            $schedule[$this->term]['principal'] = $this->lastRepaymentAmount;
        }
        if ($this->overrideEachRepayment !== null) {
            foreach ($schedule as $i => &$inst) {
                $inst['total']     = $this->overrideEachRepayment;
                $inst['principal'] = $this->overrideEachRepayment - $inst['interest'];
            }
        }
        if ($this->balloonAmount !== null) {
            $schedule[$this->term]['principal'] += $this->balloonAmount;
        }

        // 6. Skip interest/principal for first N installments
        foreach ($schedule as $i => &$inst) {
            if ($i <= $this->skipInterestFirstN) {
                $inst['interest'] = 0.0;
            }
            if ($i <= $this->skipPrincipalFirstN ||
                ($this->skipPrincipalUntilDate !== null
                 && Carbon::parse($inst['date'])->lte($this->skipPrincipalUntilDate))
            ) {
                $inst['principal'] = 0.0;
            }
        }

        // 7. Apply rounding
        foreach ($schedule as &$inst) {
            $inst['interest']  = $this->round($inst['interest']);
            $inst['principal'] = $this->round($inst['principal']);
            $inst['total']     = $this->round($inst['interest'] + $inst['principal']);
        }

        return $schedule;
    }

    /** Helper to round a value according to settings */
    protected function round(float $value): float
    {
        $factor = pow(10, $this->decimalPlaces);
        if ($this->roundUpInterest) {
            return ceil($value * $factor) / $factor;
        }
        return round($value * $factor) / $factor;
    }
}
