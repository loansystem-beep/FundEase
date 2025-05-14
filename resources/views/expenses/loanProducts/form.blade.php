@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Loan</h2>
    <form method="POST" action="{{ route('loans.store') }}">
        @csrf

        <!-- First Section: Add LoanHelp, Loan Product, Business Loan, Add/Edit Loan Products, Borrower, Loan #, Set Custom Loan # -->
        <div class="row mb-3">
            <div class="col-md-12">
                <h3>Add LoanHelp</h3>
                <p>Provide details about the loan, including loan products, borrower, and custom loan number.</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="loan_product_id" class="form-label">Loan Product</label>
                <select id="loan_product_id" name="loan_product_id" class="form-control @error('loan_product_id') is-invalid @enderror">
                    <option value="">Select Loan Product</option>
                    @foreach($loanProducts as $loanProduct)
                        <option value="{{ $loanProduct->id }}" {{ old('loan_product_id') == $loanProduct->id ? 'selected' : '' }}>{{ $loanProduct->name }}</option>
                    @endforeach
                </select>
                @error('loan_product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="business_loan" class="form-label">Business Loan</label>
                <div class="form-check">
                    <input type="checkbox" name="business_loan" id="business_loan" class="form-check-input @error('business_loan') is-invalid @enderror" {{ old('business_loan') ? 'checked' : '' }}>
                    <label class="form-check-label" for="business_loan">Is this a business loan?</label>
                </div>
                @error('business_loan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addLoanProductModal">Add/Edit Loan Products</button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="borrower_id" class="form-label">Borrower</label>
                <select id="borrower_id" name="borrower_id" class="form-control @error('borrower_id') is-invalid @enderror">
                    <option value="">Select Borrower</option>
                    @foreach($borrowers as $borrower)
                        <option value="{{ $borrower->id }}" {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>{{ $borrower->name }}</option>
                    @endforeach
                </select>
                @error('borrower_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="loan_number" class="form-label">Loan #</label>
                <input type="text" id="loan_number" name="loan_number" value="{{ old('loan_number', '1000001') }}" class="form-control @error('loan_number') is-invalid @enderror" readonly>
                @error('loan_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="custom_loan_number" class="form-label">Set Custom Loan #</label>
                <input type="text" id="custom_loan_number" name="custom_loan_number" value="{{ old('custom_loan_number') }}" class="form-control @error('custom_loan_number') is-invalid @enderror">
                @error('custom_loan_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Add more sections as needed -->

        <div class="row mb-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Create Loan</button>
            </div>
        </div>
    </form>
</div>
@endsection
