@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-700">Dashboard</h1>
    </div>

    <!-- Loan Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-2 flex items-center">
                <i class="fas fa-money-bill-wave mr-2"></i> Total Loan Amount
            </h2>
            <p class="text-3xl font-bold">KES {{ number_format($totalLoanAmount, 2) }}</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-700 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-2 flex items-center">
                <i class="fas fa-coins mr-2"></i> Amount Paid
            </h2>
            <p class="text-3xl font-bold">KES {{ number_format($amountPaid, 2) }}</p>
        </div>
        <div class="bg-gradient-to-r from-red-500 to-red-700 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-2 flex items-center">
                <i class="fas fa-balance-scale mr-2"></i> Remaining Balance
            </h2>
            <p class="text-3xl font-bold">KES {{ number_format($remainingBalance, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Repayments with Alpine.js -->
        <div x-data="{ expanded: false }" class="relative">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-history mr-2"></i> Recent Repayments
                </h2>
                <button @click="expanded = true" class="text-blue-500 hover:underline">View All</button>
            </div>

            <!-- Expanded Recent Repayments Modal -->
            <div x-show="expanded" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center backdrop-blur-lg" @click.away="expanded = false" x-transition>
                <div class="bg-white p-6 rounded-lg shadow-2xl w-3/4 max-w-4xl">
                    <h2 class="text-xl font-semibold mb-4">Recent Repayments</h2>
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border p-3">Borrower</th>
                                <th class="border p-3">Amount Paid</th>
                                <th class="border p-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRepayments as $repayment)
                                <tr class="text-center border">
                                    <td class="p-3">{{ optional($repayment->loan->borrower)->first_name ?? 'N/A' }}</td>
                                    <td class="p-3 text-green-600 font-semibold">KES {{ number_format($repayment->amount_paid, 2) }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($repayment->repayment_date)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button @click="expanded = false" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Close</button>
                </div>
            </div>
        </div>

        <!-- Upcoming Repayments with Alpine.js -->
        <div x-data="{ expanded: false }" class="relative">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i> Upcoming Repayments
                </h2>
                <button @click="expanded = true" class="text-blue-500 hover:underline">View All</button>
            </div>

            <!-- Expanded Upcoming Repayments Modal -->
            <div x-show="expanded" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center backdrop-blur-lg" @click.away="expanded = false" x-transition>
                <div class="bg-white p-6 rounded-lg shadow-2xl w-3/4 max-w-4xl">
                    <h2 class="text-xl font-semibold mb-4">Upcoming Repayments</h2>
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border p-3">Borrower</th>
                                <th class="border p-3">Amount Due</th>
                                <th class="border p-3">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingPayments as $payment)
                                <tr class="text-center border">
                                    <td class="p-3">{{ $payment->borrower->first_name }} {{ $payment->borrower->last_name }}</td>
                                    <td class="p-3 text-red-600 font-semibold">KES {{ number_format($payment->balance, 2) }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button @click="expanded = false" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
