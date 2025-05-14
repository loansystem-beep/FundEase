@extends('layouts.app')

@section('content')
@php use Carbon\Carbon; @endphp

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Loan Product</h1>

    <form action="{{ route('loanProducts.update', $loanProduct->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            @foreach($loanProduct->getAttributes() as $field => $value)
                @if(in_array($field, ['created_at', 'updated_at', 'id', 'branch_access']))
                    @continue
                @endif

                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700" for="{{ $field }}">
                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                    </label>

                    @switch($field)

                        @case('loan_release_date')
                            <div class="flex items-center gap-4">
                                <input type="text" id="loan_release_date" name="loan_release_date" class="input"
                                    value="{{ ($loanProduct->auto_set_release_date_today && !$loanProduct->loan_release_date) ? Carbon::today()->format('Y-m-d') : ($loanProduct->loan_release_date ? $loanProduct->loan_release_date->format('Y-m-d') : '') }}"
                                    {{ $loanProduct->auto_set_release_date_today ? 'disabled' : '' }}>

                                <label class="inline-flex items-center text-sm text-gray-700">
                                    <input type="checkbox" id="auto_set_release_date_today" name="auto_set_release_date_today" value="1" 
                                        {{ $loanProduct->auto_set_release_date_today ? 'checked' : '' }}
                                        onclick="toggleDateInput(this)">
                                    <span class="ml-2">Auto Set to Today's Date</span>
                                </label>
                            </div>
                            @break

                        @case('start_time')
                        @case('end_time')
                            <input type="time" id="{{ $field }}" name="{{ $field }}" class="input"
                                value="{{ Carbon::parse($value)->format('H:i') }}">
                            @break

                        @case('payment_method')
                            <select name="payment_method" id="payment_method" class="input">
                                <option value="">-- Select Method --</option>
                                <option value="cash" {{ $value === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank" {{ $value === 'bank' ? 'selected' : '' }}>Bank</option>
                            </select>
                            @break

                        @case('bank_account_id')
                            <select name="bank_account_id" id="bank_account_id" class="input">
                                <option value="">-- Select Bank Account --</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}" {{ $value == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                            @break

                        @case('branch_id')
                            <select name="branch_id" id="branch_id" class="input">
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $value == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @break

                        @case('repayment_order')
                            @php $decoded = is_array($value) ? $value : json_decode($value, true); @endphp
                            <input type="text" id="repayment_order" name="repayment_order" class="input"
                                value="{{ is_array($decoded) ? implode(', ', $decoded) : '' }}">
                            @break

                        @case('auto_payments_enabled')
                        @case('is_interest_percentage')
                        @case('extend_after_maturity')
                        @case('include_fees_after_maturity')
                        @case('keep_past_maturity_status')
                            <input type="checkbox" id="{{ $field }}" name="{{ $field }}" value="1"
                                {{ $value ? 'checked' : '' }}>
                            @break

                        @default
                            <input type="text" id="{{ $field }}" name="{{ $field }}" class="input"
                                value="{{ old($field, $value) }}">

                    @endswitch
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Changes
            </button>
            <a href="{{ route('loanProducts.show', $loanProduct->id) }}" class="text-sm text-gray-600 hover:underline">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
    .input {
        border: 1px solid #ccc;
        padding: 0.5rem;
        border-radius: 0.375rem;
        width: 100%;
    }
</style>

{{-- Include Flatpickr styles and scripts --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize flatpickr on the loan release date input field
    flatpickr("#loan_release_date", {
        dateFormat: "Y-m-d", // Format the date as YYYY-MM-DD
        defaultDate: "{{ $loanProduct->loan_release_date ? $loanProduct->loan_release_date->format('Y-m-d') : '' }}", // Set default date if available
        minDate: "today", // Disable past dates
    });

    // Toggle the date input field based on checkbox selection
    function toggleDateInput(checkbox) {
        var dateInput = document.getElementById('loan_release_date');
        if (checkbox.checked) {
            dateInput.disabled = true;
            dateInput.value = '{{ \Carbon\Carbon::today()->toDateString() }}'; // Set to today's date when auto-set is enabled
        } else {
            dateInput.disabled = false;
        }
    }
</script>

@endsection