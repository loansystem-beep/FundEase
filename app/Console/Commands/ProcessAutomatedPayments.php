<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoanProduct;
use App\Models\LoanRepayment;
use Carbon\Carbon;

class ProcessAutomatedPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-automated-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically processes the scheduled payments for loan products.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting automated payment processing...');

        // Fetch all loan products with automatic payments enabled
        $loanProducts = LoanProduct::where('auto_payments_enabled', true)
                                    ->whereNotNull('repayment_cycle')
                                    ->get();

        if ($loanProducts->isEmpty()) {
            $this->warn('No loan products found with auto payments enabled.');
            return;
        }

        foreach ($loanProducts as $loanProduct) {
            $repaymentsDue = LoanRepayment::where('loan_product_id', $loanProduct->id)
                                          ->where('due_date', '<=', Carbon::now())
                                          ->where('status', 'pending')
                                          ->get();

            if ($repaymentsDue->isEmpty()) {
                $this->warn("No pending repayments for Loan Product ID: {$loanProduct->id}");
                continue;
            }

            foreach ($repaymentsDue as $repayment) {
                $repayment->status = 'paid';
                $repayment->payment_date = Carbon::now();
                $repayment->save();

                $this->info("✅ Processed repayment ID: {$repayment->id} (Loan Product ID: {$loanProduct->id})");
            }
        }

        $this->info('✅ Automated payment processing completed.');
    }
}
