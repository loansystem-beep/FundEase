@extends('layouts.app')

@section('content')
<div class="container mx-auto px-8 py-12">

    <div class="text-center mb-8">
        <h2 class="text-3xl font-semibold text-gray-800">Loan Details</h2>
    </div>

    <!-- LOAN INFORMATION SECTION -->
    <div x-data="{ open: false }" class="bg-gray-900 bg-opacity-70 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl p-6 mt-12 transition-all hover:shadow-3xl text-white">
        <div @click="open = !open" class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-blue-500 to-teal-500 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
            <h3 class="text-2xl font-semibold">Basic Info</h3>
            <svg :class="{'rotate-180': open}" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" class="space-y-4 py-6">
            @if($loan->loan_title)<p><strong>Loan Title:</strong> {{ $loan->loan_title }}</p>@endif
            @if($loan->description)<p><strong>Description:</strong> {{ $loan->description }}</p>@endif
            <p><strong>Loan #:</strong> {{ $loan->loan_number }}</p>
            <p><strong>Borrower:</strong> {{ $loan->borrower->first_name . ' ' . $loan->borrower->last_name ?? 'N/A' }}</p>
            <p><strong>Loan Product:</strong> {{ $loan->loanProduct->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $loan->loanStatus->name ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- PRINCIPAL INFO SECTION -->
    <div x-data="{ open: false }" class="bg-amber-900 bg-opacity-70 backdrop-blur-md border border-amber-300 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
        <div @click="open = !open" class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-amber-500 to-yellow-400 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
            <h3 class="text-2xl font-semibold">Principal Info</h3>
            <svg :class="{'rotate-180': open}" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" class="space-y-4 py-6">
            <p><strong>Principal:</strong> {{ number_format($loan->principal_amount, 2) }}</p>
            @if($loan->loan_release_date)<p><strong>Release Date:</strong> {{ $loan->loan_release_date }}</p>@endif
            <p><strong>Disbursed By:</strong> {{ $loan->disburser->name ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- INTEREST INFO SECTION -->
    @if($loan->interest_method || $loan->interest_type || $loan->interest_rate)
    <div x-data="{ open: false }" class="bg-indigo-900 bg-opacity-70 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
        <div @click="open = !open" class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-pink-500 to-purple-700 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
            <h3 class="text-2xl font-semibold">Interest Info</h3>
            <svg :class="{'rotate-180': open}" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" class="space-y-4 py-6">
            @if($loan->interest_method)<p><strong>Method:</strong> {{ $loan->interest_method }}</p>@endif
            @if($loan->interest_type)<p><strong>Type:</strong> {{ $loan->interest_type }}</p>@endif
            @if($loan->interest_rate)<p><strong>Rate:</strong> {{ $loan->interest_rate }}%</p>@endif
            @if($loan->interest_period)<p><strong>Period:</strong> {{ $loan->interest_period }}</p>@endif
        </div>
    </div>
    @endif

    <!-- DURATION SECTION -->
    @if($loan->loan_duration_value)
    <div x-data="{ open: false }" class="bg-teal-900 bg-opacity-70 backdrop-blur-md border border-teal-300 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
        <div @click="open = !open" class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-teal-500 to-green-400 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
            <h3 class="text-2xl font-semibold">Duration</h3>
            <svg :class="{'rotate-180': open}" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" class="space-y-4 py-6">
            <p><strong>Duration:</strong> {{ $loan->loan_duration_value }} {{ $loan->loan_duration_type }}</p>
        </div>
    </div>
    @endif

    <!-- REPAYMENT INFO SECTION -->
    @if($loan->repayment_cycle_id || $loan->number_of_repayments)
    <div x-data="{ open: false }" class="bg-blue-900 bg-opacity-70 backdrop-blur-md border border-blue-300 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
        <div @click="open = !open" class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-400 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
            <h3 class="text-2xl font-semibold">Repayment Info</h3>
            <svg :class="{'rotate-180': open}" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div x-show="open" class="space-y-4 py-6">
            <p><strong>Repayment Cycle:</strong> {{ $loan->repaymentCycle->name ?? 'N/A' }}</p>
            <p><strong>Number of Repayments:</strong> {{ $loan->number_of_repayments }}</p>
        </div>
    </div>
    @endif

    <!-- ACTION BUTTON -->
    <div class="flex justify-center mt-10">
        <a href="{{ route('loans.edit', $loan) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-lg shadow-xl transition transform hover:scale-105">
            Edit Loan
        </a>
    </div>
</div>
@endsection
