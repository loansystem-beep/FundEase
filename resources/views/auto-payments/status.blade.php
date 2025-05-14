@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Automated Payment Status for Loan #{{ $loan->id }}</h1>
        
        @foreach ($autoPayments as $payment)
            <div>
                <p>Payment ID: {{ $payment->id }} | Status: {{ $payment->status }}</p>
            </div>
        @endforeach

        <a href="{{ route('auto-payments.toggle', ['loanId' => $loan->id]) }}" class="btn btn-primary">
            Toggle Automated Payments
        </a>
    </div>
@endsection
