@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-semibold mb-4">Guarantor Details</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-readonly label="Name" :value="$guarantor->display_name" />
        <x-readonly label="Country" :value="$guarantor->country" />
        <x-readonly label="Unique #" :value="$guarantor->unique_number" />
        <x-readonly label="Mobile" :value="$guarantor->mobile" />
        <x-readonly label="Email" :value="$guarantor->email" />
        <x-readonly label="City" :value="$guarantor->city" />
        <x-readonly label="Province" :value="$guarantor->province" />
        <x-readonly label="Loan Officer" :value="optional($guarantor->loanOfficer)->full_name" />
        @if($guarantor->photo)
            <div>
                <label class="block font-semibold mb-1">Photo</label>
                <img src="{{ asset('storage/' . $guarantor->photo) }}" class="w-32 rounded shadow">
            </div>
        @endif
        <x-readonly label="Description" :value="$guarantor->description" class="md:col-span-2" />
    </div>
</div>
@endsection
