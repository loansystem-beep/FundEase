@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Add New Bank Account</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong class="font-bold">Whoops! Something went wrong.</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bank_accounts.store') }}" method="POST" class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        @csrf

        {{-- Name --}}
        <div class="mb-6">
            <label for="name" class="block text-gray-700 font-medium mb-2">Account Name</label>
            <input type="text" id="name" name="name"
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                   value="{{ old('name') }}" required placeholder="Enter account name">
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Account Number --}}
        <div class="mb-6">
            <label for="account_number" class="block text-gray-700 font-medium mb-2">Account Number</label>
            <input type="text" id="account_number" name="account_number"
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('account_number') border-red-500 @enderror"
                   value="{{ old('account_number') }}" placeholder="Optional">
            @error('account_number')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bank Name and SWIFT Code --}}
        <div class="mb-6">
            <label for="bank_name" class="block text-gray-700 font-medium mb-2">Bank Name</label>
            <select id="bank_name" name="bank_name"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('bank_name') border-red-500 @enderror" 
                    required onchange="updateBranchAndSwiftCode()">
                <option value="" disabled selected>Select Bank</option>
                <option value="KCB Bank" {{ old('bank_name') == 'KCB Bank' ? 'selected' : '' }}>KCB Bank</option>
                <option value="Kenya Commercial Bank" {{ old('bank_name') == 'Kenya Commercial Bank' ? 'selected' : '' }}>Kenya Commercial Bank</option>
                <option value="Commercial Bank of Africa" {{ old('bank_name') == 'Commercial Bank of Africa' ? 'selected' : '' }}>Commercial Bank of Africa</option>
                <option value="Equity Bank" {{ old('bank_name') == 'Equity Bank' ? 'selected' : '' }}>Equity Bank</option>
                <option value="Standard Chartered Bank" {{ old('bank_name') == 'Standard Chartered Bank' ? 'selected' : '' }}>Standard Chartered Bank</option>
                <option value="Diamond Trust Bank" {{ old('bank_name') == 'Diamond Trust Bank' ? 'selected' : '' }}>Diamond Trust Bank</option>
                <!-- Add more banks as needed -->
            </select>
            @error('bank_name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- SWIFT Code --}}
        <div class="mb-6">
            <label for="swift_code" class="block text-gray-700 font-medium mb-2">SWIFT Code</label>
            <select id="swift_code" name="swift_code"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('swift_code') border-red-500 @enderror" 
                    required>
                <option value="" disabled selected>Select SWIFT Code</option>
                <!-- Options will be dynamically populated based on the selected bank -->
            </select>
            @error('swift_code')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Branch --}}
        <div class="mb-6">
            <label for="branch" class="block text-gray-700 font-medium mb-2">Branch</label>
            <select id="branch" name="branch"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('branch') border-red-500 @enderror" 
                    required>
                <option value="" disabled selected>Select Branch</option>
                <!-- Branch options will be dynamically populated based on the selected bank -->
            </select>
            @error('branch')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Is Active --}}
        <div class="mb-6 flex items-center">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" id="is_active" name="is_active" value="1"
                   class="mr-2" {{ old('is_active', true) ? 'checked' : '' }}>
            <label for="is_active" class="text-gray-700 font-medium">Active</label>
            @error('is_active')
                <div class="text-red-500 text-sm mt-1 ml-4">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
            Save Bank Account
        </button>
    </form>
</div>

<script>
    // Bank and Branch Data Mapping
    const bankBranches = {
        'KCB Bank': {
            'Nairobi': ['Nairobi Branch 1', 'Nairobi Branch 2'],
            'Mombasa': ['Mombasa Branch 1', 'Mombasa Branch 2'],
            'Kisumu': ['Kisumu Branch 1']
        },
        'Kenya Commercial Bank': {
            'Nairobi': ['KCB Nairobi Branch', 'KCB Nairobi Branch 2'],
            'Mombasa': ['KCB Mombasa Branch'],
            'Kisumu': ['KCB Kisumu Branch']
        },
        // Add more banks with counties and branches
    };

    const bankSwiftCodes = {
        'KCB Bank': 'KCBLKENX - KCB Bank Kenya',
        'Kenya Commercial Bank': 'KENYKENX - Kenya Commercial Bank',
        'Commercial Bank of Africa': 'CBAKKENX - Commercial Bank of Africa',
        'Equity Bank': 'EABLKENX - Equity Bank Kenya',
        'Standard Chartered Bank': 'STANKENX - Standard Chartered Bank Kenya',
        'Diamond Trust Bank': 'DTBCKENX - Diamond Trust Bank',
        // Add more banks and their swift codes with names
    };

    function updateBranchAndSwiftCode() {
        var bankName = document.getElementById('bank_name').value;
        
        // Update Branches dropdown
        var branchSelect = document.getElementById('branch');
        branchSelect.innerHTML = '<option value="" disabled selected>Select Branch</option>'; // Clear previous options
        if (bankName && bankBranches[bankName]) {
            for (const county in bankBranches[bankName]) {
                bankBranches[bankName][county].forEach(function(branch) {
                    var option = document.createElement('option');
                    option.value = branch;
                    option.textContent = `${county} - ${branch}`;
                    branchSelect.appendChild(option);
                });
            }
        }

        // Update SWIFT Code dropdown
        var swiftSelect = document.getElementById('swift_code');
        swiftSelect.innerHTML = '<option value="" disabled selected>Select SWIFT Code</option>'; // Clear previous options
        if (bankName && bankSwiftCodes[bankName]) {
            var option = document.createElement('option');
            option.value = bankSwiftCodes[bankName];
            option.textContent = bankSwiftCodes[bankName];
            swiftSelect.appendChild(option);
        }
    }
</script>

@endsection
