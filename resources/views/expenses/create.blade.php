@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8 bg-white shadow-xl rounded-2xl mt-10">
    <h2 class="text-3xl font-semibold text-gray-800 mb-8">Add New Expense</h2>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        <div class="col-span-1 md:col-span-2">
            <label class="block font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" placeholder="Enter the expense title, e.g., Office Rent" value="{{ old('title') }}" class="w-full mt-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Amount <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="amount" placeholder="Enter the amount spent, e.g., 150.75" value="{{ old('amount') }}" class="w-full mt-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Expense Type <span class="text-red-500">*</span></label>
            <input type="text" name="expense_type" placeholder="Enter the category, e.g., Travel, Office" value="{{ old('expense_type') }}" class="w-full mt-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Expense Date</label>
            <input type="date" name="expense_date" value="{{ old('expense_date') }}" class="w-full mt-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Loan (Optional)</label>
            <select name="loan_id" class="w-full mt-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Select Loan --</option>
                @foreach($loans as $loan)
                    <option value="{{ $loan->id }}" {{ old('loan_id') == $loan->id ? 'selected' : '' }}>
                        #{{ $loan->id }} - {{ $loan->borrower->first_name ?? 'Loan' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-span-1 md:col-span-2">
            <label class="block font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3" placeholder="Write details or purpose of the expense..." class="w-full mt-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
        </div>

        <div class="col-span-1 md:col-span-2">
            <label class="block font-medium text-gray-700">Custom Fields <span class="text-sm text-gray-500">(JSON format)</span></label>
            <textarea name="custom_fields" rows="3" placeholder='{"note":"Lunch with client"}' class="w-full mt-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">{{ old('custom_fields') }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Upload Receipt / Invoice</label>
            <input type="file" name="file" class="w-full mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 p-2">
        </div>

        <div class="flex items-center space-x-3">
            <input type="checkbox" name="is_recurring" value="1" {{ old('is_recurring') ? 'checked' : '' }} class="h-5 w-5 rounded text-indigo-600 focus:ring-indigo-500">
            <label class="font-medium text-gray-700">Is this a recurring expense?</label>
        </div>

        <div class="col-span-1 md:col-span-2 text-right mt-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 transition-all duration-300">
                Save Expense
            </button>
        </div>
    </form>
</div>
@endsection
