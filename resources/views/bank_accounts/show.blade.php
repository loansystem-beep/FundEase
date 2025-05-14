@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Bank Account Details</h1>
        <p class="text-gray-500">Review the details of this bank account below.</p>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">{{ $bankAccount->name }}</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $bankAccount->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $bankAccount->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                <div>
                    <p class="text-gray-500">Account Number</p>
                    <p class="font-medium">{{ $bankAccount->account_number ?: '—' }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Bank Name</p>
                    <p class="font-medium">{{ $bankAccount->bank_name }}</p>
                </div>

                <div>
                    <p class="text-gray-500">SWIFT Code</p>
                    <p class="font-medium">{{ $bankAccount->swift_code ?: '—' }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Branch</p>
                    <p class="font-medium">{{ $bankAccount->branch ?: '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('bank_accounts.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded hover:bg-gray-200 transition">
            ← Back to List
        </a>

        <a href="{{ route('bank_accounts.edit', ['bankAccount' => $bankAccount->id]) }}"
           class="inline-flex items-center px-4 py-2 bg-yellow-400 text-white text-sm font-medium rounded hover:bg-yellow-500 transition">
            ✏️ Edit
        </a>

        <form action="{{ route('bank_accounts.destroy', ['bankAccount' => $bankAccount->id]) }}"
              method="POST"
              onsubmit="return confirm('Are you sure you want to delete this bank account?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 transition">
                🗑️ Delete
            </button>
        </form>
    </div>
</div>
@endsection
