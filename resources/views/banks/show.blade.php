@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Heading -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">Bank Account Details</h1>

        <!-- Bank Details Card -->
        <div class="bg-white shadow-md rounded-lg p-6 space-y-4 border border-gray-100">
            <div class="flex justify-between">
                <span class="text-sm text-gray-600 font-medium">Code</span>
                <span class="text-sm text-gray-900 font-semibold">{{ $bank->code }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-sm text-gray-600 font-medium">Bank Account Name</span>
                <span class="text-sm text-gray-900 font-semibold">{{ $bank->bank_account_name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-sm text-gray-600 font-medium">Account Name</span>
                <span class="text-sm text-gray-900 font-semibold">{{ $bank->account_name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-sm text-gray-600 font-medium">Currency</span>
                <span class="text-sm text-gray-900 font-semibold">{{ $bank->currency }}</span>
            </div>

            <div>
                <span class="text-sm text-gray-600 font-medium block mb-1">Branches</span>
                <div class="flex flex-wrap gap-2">
                    @forelse($bank->branches as $branch)
                        <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $branch->name }}
                        </span>
                    @empty
                        <span class="text-sm text-gray-500">No branches assigned.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('banks.index') }}"
               class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium px-4 py-2 rounded-md shadow-sm transition">
                ← Back to Banks
            </a>
        </div>
    </div>
@endsection
