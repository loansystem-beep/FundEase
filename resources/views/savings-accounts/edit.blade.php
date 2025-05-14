@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Savings Account</h2>
        
        <form action="{{ route('savings-accounts.update', $savingsAccount->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="borrower_id">Borrower</label>
                <select name="borrower_id" id="borrower_id" class="form-control">
                    @foreach ($borrowers as $borrower)
                        <option value="{{ $borrower->id }}" {{ $borrower->id == $savingsAccount->borrower_id ? 'selected' : '' }}>
                            {{ $borrower->first_name }} {{ $borrower->last_name }}
                        </option>
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
                        <option value="{{ $product->id }}" {{ $product->id == $savingsAccount->savings_product_id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('savings_product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="account_number">Account Number</label>
                <input type="text" name="account_number" id="account_number" class="form-control" value="{{ $savingsAccount->account_number }}">
                @error('account_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="balance">Balance</label>
                <input type="number" name="balance" id="balance" class="form-control" value="{{ $savingsAccount->balance }}">
                @error('balance')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="account_type">Account Type</label>
                <select name="account_type" id="account_type" class="form-control">
                    <option value="basic" {{ $savingsAccount->account_type == 'basic' ? 'selected' : '' }}>Basic</option>
                    <option value="premium" {{ $savingsAccount->account_type == 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="business" {{ $savingsAccount->account_type == 'business' ? 'selected' : '' }}>Business</option>
                </select>
                @error('account_type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $savingsAccount->description }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Savings Account</button>
        </form>
    </div>
@endsection
