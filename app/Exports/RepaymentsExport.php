<?php

namespace App\Exports;

use App\Models\Repayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RepaymentsExport implements FromCollection, WithHeadings
{
    /**
     * Retrieve the data to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Repayment::with('loan.borrower') // eager load loan and borrower
            ->get()
            ->map(function ($repayment) {
                return [
                    'Loan ID' => $repayment->loan_id,
                    'Loan Amount' => $repayment->loan->amount,
                    'Amount Paid' => $repayment->amount_paid,
                    'Payment Date' => $repayment->payment_date,
                    'Status' => $repayment->status,
                    'Borrower' => $repayment->loan->borrower->first_name . ' ' . $repayment->loan->borrower->last_name,
                ];
            });
    }

    /**
     * Set the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Loan ID',
            'Loan Amount',
            'Amount Paid',
            'Payment Date',
            'Status',
            'Borrower',
        ];
    }
}
