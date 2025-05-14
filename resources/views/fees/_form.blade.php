<div class="space-y-6">
    <!-- Fee Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Fee Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $fee->name ?? '') }}" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
        @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Fee Category -->
    <div>
        <label for="category" class="block text-sm font-medium text-gray-700">Fee Category</label>
        <select name="category" id="category" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
            <option value="deductible" {{ old('category', $fee->category ?? '') == 'deductible' ? 'selected' : '' }}>Deductible</option>
            <option value="non_deductible" {{ old('category', $fee->category ?? '') == 'non_deductible' ? 'selected' : '' }}>Non-Deductible</option>
            <option value="capitalized" {{ old('category', $fee->category ?? '') == 'capitalized' ? 'selected' : '' }}>Capitalized</option>
        </select>
        @error('category')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Calculation Method -->
    <div>
        <label for="calculation_method" class="block text-sm font-medium text-gray-700">Calculation Method</label>
        <select name="calculation_method" id="calculation_method" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
            <option value="fixed" {{ old('calculation_method', $fee->calculation_method ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
            <option value="percentage" {{ old('calculation_method', $fee->calculation_method ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
        </select>
        @error('calculation_method')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Calculation Base -->
    <div>
        <label for="calculation_base" class="block text-sm font-medium text-gray-700">Calculation Base</label>
        <select name="calculation_base" id="calculation_base" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
            <option value="principal" {{ old('calculation_base', $fee->calculation_base ?? '') == 'principal' ? 'selected' : '' }}>Principal</option>
            <option value="interest" {{ old('calculation_base', $fee->calculation_base ?? '') == 'interest' ? 'selected' : '' }}>Interest</option>
            <option value="both" {{ old('calculation_base', $fee->calculation_base ?? '') == 'both' ? 'selected' : '' }}>Both</option>
        </select>
        @error('calculation_base')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Default Amount -->
    <div>
        <label for="default_amount" class="block text-sm font-medium text-gray-700">Default Amount</label>
        <input type="number" name="default_amount" id="default_amount" step="0.01" 
            value="{{ old('default_amount', $fee->default_amount ?? '') }}" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
        @error('default_amount')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Accounting Method -->
    <div>
        <label for="accounting_method" class="block text-sm font-medium text-gray-700">Accounting Method</label>
        <select name="accounting_method" id="accounting_method" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
            <option value="accrual" {{ old('accounting_method', $fee->accounting_method ?? '') == 'accrual' ? 'selected' : '' }}>Accrual</option>
            <option value="cash" {{ old('accounting_method', $fee->accounting_method ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
        </select>
        @error('accounting_method')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Accounting Type -->
    <div>
        <label for="accounting_type" class="block text-sm font-medium text-gray-700">Accounting Type</label>
        <select name="accounting_type" id="accounting_type" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
            <option value="revenue" {{ old('accounting_type', $fee->accounting_type ?? '') == 'revenue' ? 'selected' : '' }}>Revenue</option>
            <option value="payable" {{ old('accounting_type', $fee->accounting_type ?? '') == 'payable' ? 'selected' : '' }}>Payable</option>
        </select>
        @error('accounting_type')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" rows="4" 
            class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">{{ old('description', $fee->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>
</div>
