@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Heading -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Bank Account</h1>
        </div>

        <!-- Form -->
        <form action="{{ route('banks.update', $bank) }}" method="POST" class="bg-white p-6 rounded-lg shadow border border-gray-200 space-y-6">
            @csrf
            @method('PUT')

            <!-- Bank Code -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Bank Code</label>
                <input type="text" name="code" id="code" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('code', $bank->code) }}" required>
                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Bank Account Name -->
            <div>
                <label for="bank_account_name" class="block text-sm font-medium text-gray-700">Bank Account Name</label>
                <input type="text" name="bank_account_name" id="bank_account_name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('bank_account_name', $bank->bank_account_name) }}" required>
                @error('bank_account_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Account Name -->
            <div>
                <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name</label>
                <input type="text" name="account_name" id="account_name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('account_name', $bank->account_name) }}" required>
                @error('account_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Currency -->
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                <input type="text" name="currency" id="currency" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('currency', $bank->currency) }}" required>
                @error('currency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Branches -->
            <div>
                <label for="branches" class="block text-sm font-medium text-gray-700">Branches</label>
                <select name="branches[]" id="branches" multiple
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ in_array($branch->id, old('branches', $bank->branches->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                @error('branches') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow transition">
                    Update Bank Account
                </button>
                <a href="{{ route('banks.index') }}"
                    class="ml-4 text-gray-600 hover:text-gray-800 text-sm underline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
