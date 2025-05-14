@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Savings Account</h2>
        
        <form action="{{ route('savings-accounts.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="borrower_id">Borrower</label>
                <select name="borrower_id" id="borrower_id" class="form-control">
                    @foreach ($borrowers as $borrower)
                        <option value="{{ $borrower->id }}">{{ $borrower->first_name }} {{ $borrower->last_name }}</option>
                    @endforeach
                </select>
                @error('borrower_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="savings_product_id">Savings Product</label>
                <select name="savings_product_id" id="savings_product_id" class="form-control">
                    @foreach ($savingsProducts as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('savings_product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="account_number">Account Number</label>
                <input type="text" name="account_number" id="account_number" class="form-control" value="{{ old('account_number') }}">
                @error('account_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="balance">Balance</label>
                <input type="number" name="balance" id="balance" class="form-control" value="{{ old('balance') }}">
                @error('balance')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="account_type">Account Type</label>
                <select name="account_type" id="account_type" class="form-control">
                    <option value="basic">Basic</option>
                    <option value="premium">Premium</option>
                    <option value="business">Business</option>
                </select>
                @error('account_type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Savings Account</button>
        </form>
    </div>
@endsection
