<div class="space-y-4">
    <!-- Country (Required) -->
    <div class="flex">
        <x-input label="Country" name="country" type="text" required value="Kenya" />
    </div>

    <!-- First Name (Required) -->
    <div class="flex space-x-4">
        <x-input label="First Name" name="first_name" type="text" required value="{{ old('first_name', $guarantor->first_name ?? '') }}" />
        <x-input label="Middle / Last Name" name="middle_last_name" type="text" value="{{ old('middle_last_name', $guarantor->middle_last_name ?? '') }}" />
    </div>

    <!-- Business Name -->
    <div class="flex">
        <x-input label="Business Name" name="business_name" type="text" value="{{ old('business_name', $guarantor->business_name ?? '') }}" />
    </div>

    <!-- Unique Number -->
    <div class="flex">
        <x-input label="Unique Number" name="unique_number" type="text" value="{{ old('unique_number', $guarantor->unique_number ?? '') }}" />
    </div>

    <!-- Gender -->
    <div class="flex">
        <x-input label="Gender" name="gender" type="text" value="{{ old('gender', $guarantor->gender ?? '') }}" />
    </div>

    <!-- Title -->
    <div class="flex">
        <x-input label="Title" name="title" type="text" value="{{ old('title', $guarantor->title ?? '') }}" />
    </div>

    <!-- Mobile (Numbers Only) -->
    <div class="flex">
        <x-input label="Mobile" name="mobile" type="text" required value="{{ old('mobile', $guarantor->mobile ?? '') }}" />
    </div>

    <!-- Email -->
    <div class="flex">
        <x-input label="Email" name="email" type="email" value="{{ old('email', $guarantor->email ?? '') }}" />
    </div>

    <!-- Date of Birth -->
    <div class="flex">
        <x-input label="Date of Birth" name="dob" type="text" value="{{ old('dob', $guarantor->dob ?? '') }}" />
    </div>

    <!-- Address -->
    <div class="flex">
        <x-input label="Address" name="address" type="text" value="{{ old('address', $guarantor->address ?? '') }}" />
    </div>

    <!-- City -->
    <div class="flex">
        <x-input label="City" name="city" type="text" value="{{ old('city', $guarantor->city ?? '') }}" />
    </div>

    <!-- Province / State -->
    <div class="flex">
        <x-input label="Province / State" name="province_state" type="text" value="{{ old('province_state', $guarantor->province_state ?? '') }}" />
    </div>

    <!-- Zipcode -->
    <div class="flex">
        <x-input label="Zipcode" name="zipcode" type="text" value="{{ old('zipcode', $guarantor->zipcode ?? '') }}" />
    </div>

    <!-- Landline Phone -->
    <div class="flex">
        <x-input label="Landline Phone" name="landline_phone" type="text" value="{{ old('landline_phone', $guarantor->landline_phone ?? '') }}" />
    </div>

    <!-- Working Status -->
    <div class="flex">
        <x-input label="Working Status" name="working_status" type="text" value="{{ old('working_status', $guarantor->working_status ?? '') }}" />
    </div>

    <!-- Guarantor Photo -->
    <div class="flex">
        <x-input label="Guarantor Photo" name="photo" type="file" />
    </div>

    <!-- Description -->
    <div class="flex">
        <x-input label="Description" name="description" type="text" value="{{ old('description', $guarantor->description ?? '') }}" />
    </div>

    <!-- Guarantor Files -->
    <div class="flex">
        <x-input label="Guarantor Files" name="files[]" type="file" multiple />
    </div>

    <!-- Loan Officer Access -->
    <div class="flex">
        <x-input label="Loan Officer Access" name="loan_officer_access" type="text" value="{{ old('loan_officer_access', $guarantor->loan_officer_access ?? '') }}" />
    </div>
</div>
