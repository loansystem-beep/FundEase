@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Select a Subscription Plan</h1>
    
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="row">
            @foreach($plans as $plan)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $plan->name }}</h5>
                            <p class="card-text">Price: ${{ number_format($plan->price, 2) }}</p>
                            <p class="card-text">Duration: {{ $plan->duration }} month(s)</p>
                            <input type="radio" name="plan_id" value="{{ $plan->id }}" required> Select this plan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-group mt-3">
            <label for="mpesa_number">Mpesa Number</label>
            <input type="text" class="form-control" id="mpesa_number" name="mpesa_number" required>
        </div>
        <div class="form-group mt-3">
            <label for="transaction_code">Transaction Code</label>
            <input type="text" class="form-control" id="transaction_code" name="transaction_code" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit Payment</button>
    </form>
</div>
@endsection
