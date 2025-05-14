@extends('layouts.app')

@section('content')
@php use Carbon\Carbon; @endphp

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Loan Product Details</h1>

    <!-- Basic Information Section -->
    <div class="space-y-4">
        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Loan Product Name</label>
            <p>{{ $loanProduct->name ?? 'N/A' }}</p>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Unique ID</label>
            <p>{{ $loanProduct->unique_id ?? 'N/A' }}</p>
        </div>

        @if($loanProduct->short_name)
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">Short Name</label>
                <p>{{ $loanProduct->short_name }}</p>
            </div>
        @endif

        @if($loanProduct->description)
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">Description</label>
                <p>{{ $loanProduct->description }}</p>
            </div>
        @endif
    </div>

    <!-- Branch Access Section -->
    <div class="space-y-4 mt-6">
        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Branch Access</label>
            <p>
                @if($loanProduct->branch_access)
                    @php $branches = json_decode($loanProduct->branch_access); @endphp
                    @if(in_array("all", $branches))
                        All Branches
                    @else
                        @foreach($branches as $branch)
                            {{ \App\Models\Branch::find($branch)->name }}@if(!$loop->last), @endif
                        @endforeach
                    @endif
                @else
                    N/A
                @endif
            </p>
        </div>
    </div>

   <!-- Principal Amount Settings Section -->
<div class="space-y-4 mt-6">
    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Minimum Principal Amount</label>
        <p>
            @if($loanProduct->minimum_principal_amount !== null)
                {{ number_format($loanProduct->minimum_principal_amount, 2) }}
            @else
                N/A
            @endif
        </p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Default Principal Amount</label>
        <p>
            @if($loanProduct->default_principal_amount !== null)
                {{ number_format($loanProduct->default_principal_amount, 2) }}
            @else
                N/A
            @endif
        </p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Maximum Principal Amount</label>
        <p>
            @if($loanProduct->maximum_principal_amount !== null)
                {{ number_format($loanProduct->maximum_principal_amount, 2) }}
            @else
                N/A
            @endif
        </p>
    </div>
</div>

    <!-- Loan Release Date Section -->
    <div class="space-y-4 mt-6">
        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Loan Release Date</label>
            <p>{{ $loanProduct->loan_release_date ? Carbon::parse($loanProduct->loan_release_date)->format('M j, Y') : 'N/A' }}</p>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Set Loan Release Date to Today's Date</label>
            <p>{{ $loanProduct->auto_set_release_date_today ? 'Yes' : 'No' }}</p>
        </div>
    </div>

 <!-- Interest Settings Section -->
<div class="space-y-4 mt-6">
    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Interest Method</label>
        <p>{{ $loanProduct->interest_method ?? 'N/A' }}</p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Interest Type</label>
        <p>{{ $loanProduct->interest_type ?? 'N/A' }}</p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Minimum Interest</label>
        <p>
            {{ isset($loanProduct->minimum_interest) ? number_format($loanProduct->minimum_interest, 2) : 'N/A' }}
        </p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Default Interest</label>
        <p>
            {{ isset($loanProduct->default_interest) ? number_format($loanProduct->default_interest, 2) : 'N/A' }}
        </p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Maximum Interest</label>
        <p>
            {{ isset($loanProduct->maximum_interest) ? number_format($loanProduct->maximum_interest, 2) : 'N/A' }}
        </p>
    </div>
</div>


 <!-- Repayments Section -->
<div class="space-y-4 mt-6">
    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Repayment Cycle</label>
        <p>{{ $loanProduct->repayment_cycle ?? 'N/A' }}</p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Number of Repayments</label>
        <p>
            Min: {{ isset($loanProduct->minimum_number_of_repayments) ? $loanProduct->minimum_number_of_repayments : 'N/A' }},
            Default: {{ isset($loanProduct->default_number_of_repayments) ? $loanProduct->default_number_of_repayments : 'N/A' }},
            Max: {{ isset($loanProduct->maximum_number_of_repayments) ? $loanProduct->maximum_number_of_repayments : 'N/A' }}
        </p>
    </div>

    <div class="flex flex-col space-y-1">
        <label class="text-sm font-medium text-gray-700">Repayment Order</label>
        <p>{{ $loanProduct->repayment_order ? implode(', ', json_decode($loanProduct->repayment_order)) : 'N/A' }}</p>
    </div>
</div>

    <!-- Automated Payments Section -->
    @if($loanProduct->auto_payments_enabled)
        <div class="space-y-4 mt-6">
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">Enable Automated Payments</label>
                <p>Yes</p>
            </div>

            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">Start Time</label>
                <p>{{ Carbon::parse($loanProduct->start_time)->format('h:i A') }}</p>
            </div>

            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">End Time</label>
                <p>{{ Carbon::parse($loanProduct->end_time)->format('h:i A') }}</p>
            </div>

            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">Payment Method</label>
                <p>{{ ucfirst($loanProduct->payment_method) ?? 'N/A' }}</p>
            </div>

            @if($loanProduct->bank_account_id)
                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium text-gray-700">Bank Account</label>
                    <p>{{ $loanProduct->bankAccount->name ?? 'N/A' }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Post Maturity Settings Section -->
    <div class="space-y-4 mt-6">
        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Extend Loan After Maturity</label>
            <p>{{ $loanProduct->extend_after_maturity ? 'Yes' : 'No' }}</p>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Interest Type After Maturity</label>
            <p>{{ $loanProduct->interest_type_after_maturity ?? 'N/A' }}</p>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Interest Rate After Maturity</label>
            <p>{{ $loanProduct->interest_rate_after_maturity ? number_format($loanProduct->interest_rate_after_maturity, 2) : 'N/A' }}</p>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Number of Repayments After Maturity</label>
            <p>{{ $loanProduct->number_of_repayments_after_maturity ?? 'N/A' }}</p>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Include Fees After Maturity</label>
            <p>{{ $loanProduct->include_fees_after_maturity ? 'Yes' : 'No' }}</p>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">Keep Past Maturity Status</label>
            <p>{{ $loanProduct->keep_past_maturity_status ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('loanProducts.edit', $loanProduct->id) }}" class="inline-block px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md">
            Edit Loan Product
        </a>
    </div>
</div>
@endsection
