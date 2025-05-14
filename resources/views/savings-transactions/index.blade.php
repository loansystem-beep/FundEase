@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Savings Transactions</h1>

    <a href="{{ route('savings-transactions.create') }}" class="btn btn-primary mb-3">Create New Transaction</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Borrower</th>
                <th>Savings Account</th>
                <th>Action</th>
                <th>Transaction Date</th>
                <th>Ledger Balance</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Receipt</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->borrower->first_name }} {{ $transaction->borrower->last_name }}</td> <!-- Using first and last name -->
                    <td>{{ $transaction->savingsAccount->account_number }}</td>
                    <td>{{ $transaction->action }}</td>
                    <td>{{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($transaction->ledger_balance, 2) }}</td>
                    <td>{{ number_format($transaction->debit, 2) }}</td>
                    <td>{{ number_format($transaction->credit, 2) }}</td>
                    <td>{{ $transaction->receipt }}</td>
                    <td>
                        <a href="{{ route('savings-transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('savings-transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $transactions->links() }}
</div>
@endsection
