@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="mb-6">
        <h2 class="text-3xl font-semibold text-gray-800">Edit Bank Account</h2>
        <p class="text-gray-500">Update the details below.</p>
    </div>

    <!-- Displaying validation errors -->
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bank_accounts.update', $bankAccount) }}" method="POST" class="bg-white shadow-lg rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Account Name</label>
            <input type="text" name="name" value="{{ old('name', $bankAccount->name) }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Account Number <span class="text-gray-400 text-xs">(Optional)</span></label>
            <input type="text" name="account_number" value="{{ old('account_number', $bankAccount->account_number) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('account_number') border-red-500 @enderror">
            @error('account_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Bank Name</label>
            <select name="bank_name" id="bank_name" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('bank_name') border-red-500 @enderror">
                <option value="">Select Bank</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank }}" {{ old('bank_name', $bankAccount->bank_name) === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                @endforeach
            </select>
            @error('bank_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">SWIFT Code</label>
            <select name="swift_code" id="swift_code"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('swift_code') border-red-500 @enderror">
                <option value="">Select SWIFT Code</option>
                @foreach($swiftCodes as $code)
                    <option value="{{ $code }}" {{ old('swift_code', $bankAccount->swift_code) === $code ? 'selected' : '' }}>{{ $code }}</option>
                @endforeach
            </select>
            @error('swift_code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Branch</label>
            <select name="branch" id="branch"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('branch') border-red-500 @enderror">
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch }}" {{ old('branch', $bankAccount->branch) === $branch ? 'selected' : '' }}>{{ $branch }}</option>
                @endforeach
            </select>
            @error('branch')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                💾 Update
            </button>

            <a href="{{ route('bank_accounts.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // When the bank is selected, load SWIFT codes related to the bank
    document.getElementById('bank_name').addEventListener('change', function () {
        const bankName = this.value;
        fetch(`/swift-codes/${bankName}`)
            .then(response => response.json())
            .then(data => {
                const swiftCodeSelect = document.getElementById('swift_code');
                swiftCodeSelect.innerHTML = '<option value="">Select SWIFT Code</option>'; // Reset options
                data.forEach(function (code) {
                    const option = document.createElement('option');
                    option.value = code;
                    option.textContent = code;
                    swiftCodeSelect.appendChild(option);
                });
            });
    });

    // When a SWIFT code is selected, load the branches related to it
    document.getElementById('swift_code').addEventListener('change', function () {
        const swiftCode = this.value;
        fetch(`/branches/${swiftCode}`)
            .then(response => response.json())
            .then(data => {
                const branchSelect = document.getElementById('branch');
                branchSelect.innerHTML = '<option value="">Select Branch</option>'; // Reset options
                data.forEach(function (branch) {
                    const option = document.createElement('option');
                    option.value = branch;
                    option.textContent = branch;
                    branchSelect.appendChild(option);
                });
            });
    });
</script>
@endpush
