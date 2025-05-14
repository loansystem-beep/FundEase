@extends('layouts.app')

@section('content')
<div class="container">
    <h1>View Savings Transaction</h1>

    <div class="card">
        <div class="card-header">
            Transaction Details
        </div>
        <div class="card-body">
            <h5 class="card-title">Borrower: {{ $savingsTransaction->borrower->first_name }} {{ $savingsTransaction->borrower->last_name }}</h5> <!-- Using first and last name -->
            <p><strong>Savings Account:</strong> {{ $savingsTransaction->savingsAccount->account_number }}</p>
            <p><strong>Action:</strong> {{ $savingsTransaction->action }}</p>
            <p><strong>Ledger Balance:</strong> {{ number_format($savingsTransaction->ledger_balance, 2) }}</p>
            <p><strong>Transaction Date:</strong> {{ $savingsTransaction->transaction_date->format('d/m/Y H:i') }}</p>
            <p><strong>Type:</strong> {{ $savingsTransaction->type }}</p>
            <p><strong>Description:</strong> {{ $savingsTransaction->description }}</p>
            <p><strong>Debit:</strong> {{ number_format($savingsTransaction->debit, 2) }}</p>
            <p><strong>Credit:</strong> {{ number_format($savingsTransaction->credit, 2) }}</p>
            <p><strong>Receipt:</strong> {{ $savingsTransaction->receipt }}</p>
        </div>
        <div class="card-footer text-muted">
            <a href="{{ route('savings-transactions.index') }}" class="btn btn-secondary">Back to Transactions</a>
        </div>
    </div>
</div>
@endsection
