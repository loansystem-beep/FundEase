@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Repayment History</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Loan ID</th>
                    <th>Borrower</th>
                    <th>Amount Paid</th>
                    <th>Repayment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($repayments as $repayment)
                    <tr>
                        <td>{{ $repayment->loan->id }}</td>
                        <td>{{ $repayment->loan->borrower->first_name }} {{ $repayment->loan->borrower->last_name }}</td>
                        <td>{{ $repayment->amount_paid }}</td>
                        <td>{{ $repayment->repayment_date->format('d-m-Y') }}</td>
                        <td>{{ $repayment->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


