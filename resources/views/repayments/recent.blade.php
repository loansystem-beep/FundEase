@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Recent Repayments</h1>

    <div class="bg-white shadow-md rounded-md overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Repayment ID</th>
                    <th class="px-6 py-3 text-left">Loan ID</th>
                    <th class="px-6 py-3 text-left">Amount Paid</th>
                    <th class="px-6 py-3 text-left">Repayment Date</th>
                    <th class="px-6 py-3 text-left">Loan Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRepayments as $repayment)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4">{{ $repayment->id }}</td>
                        <td class="px-6 py-4">{{ $repayment->loan->id }}</td>
                        <td class="px-6 py-4">{{ number_format($repayment->amount_paid, 2) }}</td>
                        <td class="px-6 py-4">{{ $repayment->repayment_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">{{ number_format($repayment->loan->balance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
