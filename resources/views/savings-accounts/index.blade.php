@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Savings Accounts</h2>

    <a href="{{ route('savings-accounts.create') }}" class="btn btn-primary mb-3">Add Savings Account</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Account #</th>
                <th>Borrower</th>
                <th>Product</th>
                <th>Type</th>
                <th>Balance</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($savingsAccounts as $account)
            <tr>
                <td>{{ $account->account_number }}</td>
                <td>{{ $account->borrower->name ?? 'N/A' }}</td>
                <td>{{ $account->savingsProduct->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($account->account_type) }}</td>
                <td>{{ number_format($account->balance, 2) }}</td>
                <td>{{ $account->description }}</td>
                <td>
                    <a href="{{ route('savings_accounts.edit', $account->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('savings_accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this account?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
