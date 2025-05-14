@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Edit Repayment</h2>

    <form action="{{ route('repayments.update', $repayment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="loan_id" class="block text-gray-700">Loan</label>
            <select name="loan_id" id="loan_id" class="p-3 border rounded-lg w-full">
                @foreach($loans as $loan)
                    <option value="{{ $loan->id }}" {{ $loan->id == $repayment->loan_id ? 'selected' : '' }}>
                        {{ $loan->id }} - {{ $loan->amount }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="amount_paid" class="block text-gray-700">Amount Paid</label>
            <input type="number" name="amount_paid" id="amount_paid" class="p-3 border rounded-lg w-full" value="{{ $repayment->amount_paid }}" required>
        </div>

        <div class="mb-4">
            <label for="repayment_date" class="block text-gray-700">Repayment Date</label>
            <input type="date" name="repayment_date" id="repayment_date" class="p-3 border rounded-lg w-full" value="{{ $repayment->repayment_date }}" required>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status</label>
            <select name="status" id="status" class="p-3 border rounded-lg w-full">
                <option value="pending" {{ $repayment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $repayment->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-yellow-600">Update Repayment</button>
    </form>
</div>
@endsection
