@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Repayment Details</h2>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div><strong>Loan ID:</strong> {{ $repayment->loan_id }}</div>
        <div><strong>Amount Paid:</strong> {{ number_format($repayment->amount_paid, 2) }}</div>
        <div><strong>Repayment Date:</strong> {{ $repayment->repayment_date }}</div>
        <div><strong>Status:</strong> {{ ucfirst($repayment->status) }}</div>
    </div>
</div>
@endsection
