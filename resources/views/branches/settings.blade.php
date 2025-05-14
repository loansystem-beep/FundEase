@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Branch Settings - {{ $branch->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('branches.settings.update', $branch) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Min and Max Loan Amount -->
        <div class="mb-3">
            <label for="min_loan_amount" class="form-label">Minimum Loan Amount</label>
            <input type="number" name="min_loan_amount" id="min_loan_amount" value="{{ old('min_loan_amount', $branch->min_loan_amount) }}" class="form-control" min="0">
        </div>

        <div class="mb-3">
            <label for="max_loan_amount" class="form-label">Maximum Loan Amount</label>
            <input type="number" name="max_loan_amount" id="max_loan_amount" value="{{ old('max_loan_amount', $branch->max_loan_amount) }}" class="form-control" min="0">
        </div>

        <!-- Min and Max Interest Rate -->
        <div class="mb-3">
            <label for="min_interest_rate" class="form-label">Minimum Interest Rate (%)</label>
            <input type="number" step="0.01" name="min_interest_rate" id="min_interest_rate" value="{{ old('min_interest_rate', $branch->min_interest_rate) }}" class="form-control" min="0">
        </div>

        <div class="mb-3">
            <label for="max_interest_rate" class="form-label">Maximum Interest Rate (%)</label>
            <input type="number" step="0.01" name="max_interest_rate" id="max_interest_rate" value="{{ old('max_interest_rate', $branch->max_interest_rate) }}" class="form-control" min="0">
        </div>

        <!-- Holidays -->
        <div class="mb-3">
            <label for="holidays" class="form-label">Branch Holidays (Select Dates)</label>
            <input type="date" name="holidays[]" class="form-control" value="{{ old('holidays[]', isset($branch->holidays) ? implode(',', $branch->holidays) : '') }}" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
