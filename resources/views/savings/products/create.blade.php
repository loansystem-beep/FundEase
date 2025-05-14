{{-- resources/views/savings/products/create.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Savings Product</h1>
        <form action="{{ route('savings.products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="interest_rate">Interest Rate (%)</label>
                <input type="number" name="interest_rate" id="interest_rate" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="interest_type">Interest Type</label>
                <select name="interest_type" id="interest_type" class="form-control" required>
                    <option value="flat">Flat</option>
                    <option value="compound">Compound</option>
                </select>
            </div>
            <div class="form-group">
                <label for="allow_withdrawals">Allow Withdrawals</label>
                <select name="allow_withdrawals" id="allow_withdrawals" class="form-control" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Product</button>
        </form>
    </div>
@endsection
