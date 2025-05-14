<div class="space-y-4">

    <!-- Name Field -->
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('name', $branch->name ?? '') }}" required placeholder="Enter branch name">
    </div>

    <!-- Code Field -->
    <div class="mb-4">
        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
        <input type="text" name="code" id="code" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('code', $branch->code ?? '') }}" placeholder="Enter branch code (optional)">
    </div>

    <!-- Location Field -->
    <div class="mb-4">
        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
        <input type="text" name="location" id="location" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('location', $branch->location ?? '') }}" placeholder="Enter branch location">
    </div>

    <!-- Country Field -->
    <div class="mb-4">
        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
        <select name="country" id="country" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Select country">
            <option value="">Select a Country</option>
            @foreach($countries_and_currencies as $country => $currency)
                <option value="{{ $country }}" {{ old('country', $branch->country ?? '') == $country ? 'selected' : '' }}>{{ $country }}</option>
            @endforeach
        </select>
    </div>

    <!-- Currency Field (Dynamically updated based on selected country) -->
    <div class="mb-4">
        <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
        <select name="currency" id="currency" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Select currency">
            <option value="">Select Currency</option>
            @foreach($countries_and_currencies as $country => $currency)
                <option value="{{ $currency }}" {{ old('currency', $branch->currency ?? '') == $currency ? 'selected' : '' }} data-country="{{ $country }}">
                    {{ $currency }} ({{ $country }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Date Format Dropdown -->
<div class="mb-4">
    <label for="date_format" class="block text-sm font-medium text-gray-700">Date Format</label>
    <select name="date_format" id="date_format" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">Select a format</option>
        @php
            $formats = [
                'Y-m-d' => 'YYYY-MM-DD (2025-05-14)',
                'd-m-Y' => 'DD-MM-YYYY (14-05-2025)',
                'm/d/Y' => 'MM/DD/YYYY (05/14/2025)',
                'd/m/Y' => 'DD/MM/YYYY (14/05/2025)',
                'M d, Y' => 'Mon DD, YYYY (May 14, 2025)',
                'd M Y' => 'DD Mon YYYY (14 May 2025)',
            ];
            $selectedFormat = old('date_format', $branch->date_format ?? '');
        @endphp
        @foreach($formats as $value => $label)
            <option value="{{ $value }}" {{ $selectedFormat == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>


    <!-- Address Field -->
    <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <textarea name="address" id="address" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter branch address">{{ old('address', $branch->address ?? '') }}</textarea>
    </div>

    <!-- Phone Field -->
    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" name="phone" id="phone" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('phone', $branch->phone ?? '') }}" placeholder="Enter branch phone number">
    </div>

    <!-- Email Field -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email', $branch->email ?? '') }}" placeholder="Enter branch email">
    </div>

    <!-- Description Field -->
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter branch description">{{ old('description', $branch->description ?? '') }}</textarea>
    </div>

    <!-- Submit Button -->
    <div class="mb-4">
        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">{{ $button }}</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize the date picker for Date Format input field
    flatpickr("#date_format", {
        altInput: true,
        altFormat: "F j, Y", // Example: March 14, 2023
        dateFormat: "Y-m-d",  // Format used in the input field when submitting the form
        allowInput: true,
        minDate: "today",
    });

    // JavaScript to update currency based on selected country
    document.getElementById('country').addEventListener('change', function () {
        let selectedCountry = this.value;
        let currencyDropdown = document.getElementById('currency');

        // Loop through each currency option
        Array.from(currencyDropdown.options).forEach(function (option) {
            if (option.dataset.country === selectedCountry || selectedCountry === '') {
                option.style.display = 'block'; // Show matched currencies
            } else {
                option.style.display = 'none'; // Hide non-matched currencies
            }
        });

        // Reset currency selection if country changes
        if (selectedCountry === '') {
            currencyDropdown.value = '';
        }
    });

    // JavaScript to update phone number placeholder based on selected country
    document.getElementById('country').addEventListener('change', function () {
        let selectedCountry = this.value;
        let phoneInput = document.getElementById('phone');
        
        let countryPhoneFormats = {
            'Kenya': '+254 XXX XXX XXX',
            'Uganda': '+256 XXX XXX XXX',
            'Tanzania': '+255 XXX XXX XXX',
            'Nigeria': '+234 XXX XXX XXXX',
            'South Africa': '+27 XXX XXX XXXX',
            'United States': '+1 XXX XXX XXXX',
            'United Kingdom': '+44 XXX XXX XXXX',
            // Add other countries as needed
        };

        // Update phone number placeholder based on selected country
        if (countryPhoneFormats[selectedCountry]) {
            phoneInput.placeholder = countryPhoneFormats[selectedCountry];
        } else {
            phoneInput.placeholder = 'Enter phone number';
        }
    });
</script>
