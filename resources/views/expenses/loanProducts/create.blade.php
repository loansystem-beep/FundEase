@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Loan Product</h2>

        <form action="{{ route('loanProducts.store') }}" method="POST">
            @csrf

           <!-- Loan Product Details -->
<div x-data="{ open: true, showInfo: false }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-4">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer">
        <h3 class="text-lg font-semibold text-gray-800">Loan Product Details</h3>
        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 text-gray-600 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div x-show="open" class="p-4 space-y-6" x-transition>
        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfo" x-model="showInfo" class="form-checkbox rounded text-blue-600">
            <label for="toggleInfo" class="text-sm text-gray-700">Show field descriptions</label>
        </div>

        <!-- Loan Product Name -->
        <div class="form-group">
            <label for="name" class="block font-medium mb-1">Loan Product Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Personal Loan" value="{{ old('name') }}" required>
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">This is the name of the loan product customers will see when selecting a loan type.</p>
            </template>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Unique ID -->
        <div class="form-group">
            <label for="unique_id" class="block font-medium mb-1">Unique ID</label>
            <input type="text" name="unique_id" id="unique_id" class="form-control" placeholder="e.g. PL-001" value="{{ old('unique_id') }}" required>
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">The system identifier for this loan product. Must be unique.</p>
            </template>
            @error('unique_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


        <!-- Branch Access Section -->
<div x-data="{ open: false, showInfo: false }"
     class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-6">

    <div @click="open = !open"
         class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Branch Access</h3>
        <span x-show="!open" class="text-gray-400">+</span>
        <span x-show="open" class="text-red-400 text-sm">✕</span>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">

        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfoBranch" x-model="showInfo"
                   class="form-checkbox rounded text-blue-600">
            <label for="toggleInfoBranch" class="text-sm text-gray-700">
                Show field descriptions
            </label>
        </div>

        <p class="text-sm text-gray-600">
            Choose whether this loan product is accessible to all branches or only specific ones.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <!-- Branch Access Multi-Select -->
            <div>
                <label for="branch_access" class="block text-sm font-medium text-gray-700">
                    Branch Access
                </label>
                <select name="branch_access[]" id="branch_access" multiple
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm
                               focus:ring-primary-500 focus:border-primary-500
                               @error('branch_access') border-red-500 @enderror">
                    <option value="">— All Branches —</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ in_array(
                                  $branch->id,
                                  old(
                                    'branch_access',
                                    isset($loanProduct) ? $loanProduct->branch_access : []
                                  )
                                )
                                ? 'selected'
                                : ''
                            }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">
                        Select one or multiple branches that can offer this loan product. Leave blank for all.
                    </p>
                </template>
                @error('branch_access')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Primary Branch Dropdown -->
            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">
                    Primary Branch
                </label>
                <select name="branch_id" id="branch_id"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm
                               focus:ring-primary-500 focus:border-primary-500
                               @error('branch_id') border-red-500 @enderror">
                    <option value="">Select a branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ old(
                                  'branch_id',
                                  isset($loanProduct) ? $loanProduct->branch_id : ''
                                ) == $branch->id
                                ? 'selected'
                                : ''
                            }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">
                        Assign a default branch for reporting or organization purposes.
                    </p>
                </template>
                @error('branch_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Add/Edit Branch Button -->
            <div class="sm:col-span-2">
                <a href="{{ route('branches.index') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700
                          bg-blue-100 hover:bg-blue-200 rounded-md shadow-sm transition">
                    Add / Edit Branch
                </a>
            </div>

        </div>
    </div>
</div>




      <!-- Advanced Settings Toggle -->
      <div class="mt-8 mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="advanced_settings" class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700 font-semibold">Show Advanced Fields</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">Advanced configuration options like Principal, Disbursement, and Release Date settings.</p>
            </div>

            <!-- Advanced Settings Section -->
            <div id="advanced_fields" style="display: none;">
            <!-- Principal Amount Settings -->
<div x-data="{ open: true, showInfo: false }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-4">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Principal Amount Settings</h3>
        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 text-gray-600 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">
        <div class="form-group">
            <label for="minimum_principal_amount" class="block text-sm font-medium text-gray-700">Minimum Principal Amount</label>
            <input
                type="number"
                name="minimum_principal_amount"
                id="minimum_principal_amount"
                class="form-control"
                placeholder="Enter minimum loan amount"
                value="{{ old('minimum_principal_amount', $loanProduct->minimum_principal_amount ?? '') }}"
            >
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">
                    The minimum principal amount allowed when creating a loan under this product.
                </p>
            </template>
            @error('minimum_principal_amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="default_principal_amount" class="block text-sm font-medium text-gray-700">Default Principal Amount</label>
            <input
                type="number"
                name="default_principal_amount"
                id="default_principal_amount"
                class="form-control"
                placeholder="Enter default loan amount"
                value="{{ old('default_principal_amount', $loanProduct->default_principal_amount ?? '') }}"
            >
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">
                    The default principal value pre-filled when selecting this loan product.
                </p>
            </template>
            @error('default_principal_amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="maximum_principal_amount" class="block text-sm font-medium text-gray-700">Maximum Principal Amount</label>
            <input
                type="number"
                name="maximum_principal_amount"
                id="maximum_principal_amount"
                class="form-control"
                placeholder="Enter maximum loan amount"
                value="{{ old('maximum_principal_amount', $loanProduct->maximum_principal_amount ?? '') }}"
            >
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">
                    The maximum principal amount allowed for loans under this product.
                </p>
            </template>
            @error('maximum_principal_amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>



<!-- Disbursement Settings -->
<div x-data="{ open: true, showInfo: false }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-4">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Disbursement Settings</h3>
        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 text-gray-600 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">
        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfoDisbursement" x-model="showInfo" class="form-checkbox rounded text-blue-600">
            <label for="toggleInfoDisbursement" class="text-sm text-gray-700">Show field descriptions</label>
        </div>

        <!-- Disbursed By Field -->
        <div class="form-group">
            <label for="disbursed_by" class="block text-sm font-medium text-gray-700">Disbursed By</label>
            <select name="disbursed_by" id="disbursed_by" class="form-control">
                <option value="Cash" {{ old('disbursed_by') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Cheque" {{ old('disbursed_by') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                <option value="Wire Transfer" {{ old('disbursed_by') == 'Wire Transfer' ? 'selected' : '' }}>Wire Transfer</option>
                <option value="Online Transfer" {{ old('disbursed_by') == 'Online Transfer' ? 'selected' : '' }}>Online Transfer</option>
            </select>
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">Select the method by which the loan will be disbursed to the borrower.</p>
            </template>

            @error('disbursed_by')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>




<!-- Loan Release Date Settings -->
<div x-data="{ open: true, showInfo: false }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-4">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Loan Release Date Settings</h3>
        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 text-gray-600 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">
        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfoReleaseDate" x-model="showInfo" class="form-checkbox rounded text-blue-600">
            <label for="toggleInfoReleaseDate" class="text-sm text-gray-700">Show field descriptions</label>
        </div>

        <!-- Date Picker -->
        <div class="form-group">
            <label for="loan_release_date" class="block font-medium mb-2">Loan Release Date</label>
            <input type="date" name="loan_release_date" id="loan_release_date"
                   class="form-input w-full"
                   value="{{ old('loan_release_date', optional($loanProduct ?? null)->loan_release_date) }}">
            @error('loan_release_date')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">Select the loan release date manually or use the checkbox below to auto-set today's date.</p>
            </template>
        </div>

        <!-- Auto-set checkbox -->
        <div class="form-check">
            <input type="checkbox" id="auto_set_release_date_today" name="auto_set_release_date_today"
                   value="1"
                   {{ old('auto_set_release_date_today', optional($loanProduct ?? null)->auto_set_release_date_today) ? 'checked' : '' }}
                   class="form-checkbox text-blue-600"
                   @change="if($event.target.checked) { document.getElementById('loan_release_date').value = new Date().toISOString().split('T')[0]; } else { document.getElementById('loan_release_date').value = ''; }">
            <label for="auto_set_release_date_today" class="text-sm text-gray-700 ml-2">Set Loan Release Date to Today's Date</label>
        </div>
    </div>
</div>

<!-- Interest Settings -->
<div class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-4">
    <div class="px-4 py-3 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-800">Interest Settings</h3>
    </div>

    <div class="p-4 space-y-4">
        <!-- Interest Method -->
        <div>
            <label for="interest_method" class="block text-sm font-medium text-gray-700">Interest Method</label>
            <select name="interest_method" id="interest_method" class="form-select mt-1 block w-full">
                <option value="percentage" {{ old('interest_method') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                <option value="fixed" {{ old('interest_method') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
            </select>
            @error('interest_method')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Interest Type -->
        <div>
            <label for="interest_type" class="block text-sm font-medium text-gray-700">Interest Type</label>
            <select name="interest_type" id="interest_type" class="form-select mt-1 block w-full">
                <option value="simple" {{ old('interest_type') == 'simple' ? 'selected' : '' }}>Simple</option>
                <option value="compound" {{ old('interest_type') == 'compound' ? 'selected' : '' }}>Compound</option>
            </select>
            @error('interest_type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Interest Period -->
        <div>
            <label for="interest_period" class="block text-sm font-medium text-gray-700">Interest Period</label>
            <select name="interest_period" id="interest_period" class="form-select mt-1 block w-full">
                <option value="daily" {{ old('interest_period') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('interest_period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ old('interest_period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ old('interest_period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
            @error('interest_period')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Min Interest -->
        <div>
            <label for="minimum_interest" class="block text-sm font-medium text-gray-700">Minimum Interest</label>
            <input type="number" step="0.01" name="minimum_interest" id="minimum_interest" class="form-input mt-1 block w-full" value="{{ old('minimum_interest') }}">
            @error('minimum_interest')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Default Interest -->
        <div>
            <label for="default_interest" class="block text-sm font-medium text-gray-700">Default Interest</label>
            <input type="number" step="0.01" name="default_interest" id="default_interest" class="form-input mt-1 block w-full" value="{{ old('default_interest') }}">
            @error('default_interest')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Max Interest -->
        <div>
            <label for="maximum_interest" class="block text-sm font-medium text-gray-700">Maximum Interest</label>
            <input type="number" step="0.01" name="maximum_interest" id="maximum_interest" class="form-input mt-1 block w-full" value="{{ old('maximum_interest') }}">
            @error('maximum_interest')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>



<!-- Loan Duration Settings -->
<div x-data="{ open: true, showInfo: false }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-4">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Loan Duration Settings</h3>
        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 text-gray-600 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">
        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfoLoanDuration" x-model="showInfo" class="form-checkbox rounded text-blue-600">
            <label for="toggleInfoLoanDuration" class="text-sm text-gray-700">Show field descriptions</label>
        </div>

        <!-- Loan Duration Period Field -->
        <div class="form-group">
            <label for="loan_duration_period" class="block text-sm font-medium text-gray-700">Loan Duration Period</label>
            <select name="loan_duration_period" id="loan_duration_period" class="form-control">
                <option value="days" {{ old('loan_duration_period') == 'days' ? 'selected' : '' }}>Days</option>
                <option value="months" {{ old('loan_duration_period') == 'months' ? 'selected' : '' }}>Months</option>
                <option value="years" {{ old('loan_duration_period') == 'years' ? 'selected' : '' }}>Years</option>
            </select>
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">Select the unit for the loan duration (e.g., days, months, or years).</p>
            </template>

            @error('loan_duration_period')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Minimum Loan Duration Field -->
        <div class="form-group">
            <label for="minimum_loan_duration" class="block text-sm font-medium text-gray-700">Minimum Loan Duration</label>
            <input type="number" name="minimum_loan_duration" id="minimum_loan_duration" class="form-control" value="{{ old('minimum_loan_duration') }}">
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">Set the minimum duration for the loan (in selected period).</p>
            </template>

            @error('minimum_loan_duration')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Default Loan Duration Field -->
        <div class="form-group">
            <label for="default_loan_duration" class="block text-sm font-medium text-gray-700">Default Loan Duration</label>
            <input type="number" name="default_loan_duration" id="default_loan_duration" class="form-control" value="{{ old('default_loan_duration') }}">
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">Set the default loan duration (in selected period).</p>
            </template>

            @error('default_loan_duration')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Maximum Loan Duration Field -->
        <div class="form-group">
            <label for="maximum_loan_duration" class="block text-sm font-medium text-gray-700">Maximum Loan Duration</label>
            <input type="number" name="maximum_loan_duration" id="maximum_loan_duration" class="form-control" value="{{ old('maximum_loan_duration') }}">
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">Set the maximum duration for the loan (in selected period).</p>
            </template>

            @error('maximum_loan_duration')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<!-- Repayments Section -->
<div x-data="{ open: true, showInfo: false }" class="bg-white rounded-2xl shadow p-6 mt-6">
    <div @click="open = !open" class="flex items-center justify-between mb-4 cursor-pointer">
        <h2 class="text-xl font-semibold">Repayments</h2>
        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 text-gray-600 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div x-show="open" x-transition.duration.300ms>
        <div class="flex items-center space-x-4 mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" id="showRepaymentInfo" class="form-checkbox h-5 w-5 text-primary-600">
                <span class="ml-2 text-sm text-gray-600">Show field information</span>
            </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Repayment Cycle -->
            <div>
                <label for="repayment_cycle" class="block text-sm font-medium text-gray-700 mb-1">Repayment Cycle</label>
                <select id="repayment_cycle" name="repayment_cycle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Select Repayment Cycle</option>
                    <option value="Daily" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Daily' ? 'selected' : '' }}>Daily</option>
                    <option value="Weekly" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="Biweekly" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Biweekly' ? 'selected' : '' }}>Biweekly</option>
                    <option value="Monthly" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Bimonthly" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Bimonthly' ? 'selected' : '' }}>Bimonthly</option>
                    <option value="Quarterly" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                    <option value="Every 4 Months" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Every 4 Months' ? 'selected' : '' }}>Every 4 Months</option>
                    <option value="Semi-Annual" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Semi-Annual' ? 'selected' : '' }}>Semi-Annual</option>
                    <option value="Every 9 Months" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Every 9 Months' ? 'selected' : '' }}>Every 9 Months</option>
                    <option value="Yearly" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                    <option value="Lump-Sum" {{ old('repayment_cycle', $loanProduct->repayment_cycle ?? '') == 'Lump-Sum' ? 'selected' : '' }}>Lump-Sum</option>
                </select>
                <p id="repaymentCycleInfo" class="text-xs text-gray-500 mt-1 hidden">
                    Select how often the borrower will be required to make repayments (e.g., monthly, weekly).
                </p>
                @error('repayment_cycle')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Minimum Number of Repayments -->
            <div>
                <label for="minimum_number_of_repayments" class="block text-sm font-medium text-gray-700 mb-1">Minimum Number of Repayments</label>
                <input type="number" id="minimum_number_of_repayments" name="minimum_number_of_repayments" 
                    value="{{ old('minimum_number_of_repayments', $loanProduct->minimum_number_of_repayments ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" 
                    placeholder="e.g., 6">
                <p id="minimumRepaymentsInfo" class="text-xs text-gray-500 mt-1 hidden">
                    The minimum allowed number of repayment installments for the loan.
                </p>
                @error('minimum_number_of_repayments')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Default Number of Repayments -->
            <div>
                <label for="default_number_of_repayments" class="block text-sm font-medium text-gray-700 mb-1">Default Number of Repayments</label>
                <input type="number" id="default_number_of_repayments" name="default_number_of_repayments" 
                    value="{{ old('default_number_of_repayments', $loanProduct->default_number_of_repayments ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" 
                    placeholder="e.g., 12">
                <p id="defaultRepaymentsInfo" class="text-xs text-gray-500 mt-1 hidden">
                    The default number of repayments suggested during loan creation.
                </p>
                @error('default_number_of_repayments')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Maximum Number of Repayments -->
            <div>
                <label for="maximum_number_of_repayments" class="block text-sm font-medium text-gray-700 mb-1">Maximum Number of Repayments</label>
                <input type="number" id="maximum_number_of_repayments" name="maximum_number_of_repayments" 
                    value="{{ old('maximum_number_of_repayments', $loanProduct->maximum_number_of_repayments ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500" 
                    placeholder="e.g., 24">
                <p id="maximumRepaymentsInfo" class="text-xs text-gray-500 mt-1 hidden">
                    The maximum allowed number of repayment installments for the loan.
                </p>
                @error('maximum_number_of_repayments')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to toggle descriptions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const showInfoCheckbox = document.getElementById('showRepaymentInfo');
    const infos = [
        document.getElementById('repaymentCycleInfo'),
        document.getElementById('minimumRepaymentsInfo'),
        document.getElementById('defaultRepaymentsInfo'),
        document.getElementById('maximumRepaymentsInfo'),
    ];

    showInfoCheckbox.addEventListener('change', function() {
        infos.forEach(info => {
            if (showInfoCheckbox.checked) {
                info.classList.remove('hidden');
            } else {
                info.classList.add('hidden');
            }
        });
    });
});
</script>




<!-- Repayment Order Settings -->
<div x-data="{ open: true, showInfo: false }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-4">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Repayment Order Settings</h3>
        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 text-gray-600 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">
        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfoRepaymentOrder" x-model="showInfo" class="form-checkbox rounded text-blue-600">
            <label for="toggleInfoRepaymentOrder" class="text-sm text-gray-700">Show field descriptions</label>
        </div>

        <!-- Repayment Order Field -->
        <div>
            <label for="repayment_order" class="block text-sm font-medium text-gray-700">Repayment Order</label>
            <select name="repayment_order[]" id="repayment_order"
                class="form-select block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 @error('repayment_order') border-red-500 @enderror"
                multiple>
                <option value="penalty" {{ in_array('penalty', old('repayment_order', [])) ? 'selected' : '' }}>Penalty</option>
                <option value="fees" {{ in_array('fees', old('repayment_order', [])) ? 'selected' : '' }}>Fees</option>
                <option value="interest" {{ in_array('interest', old('repayment_order', [])) ? 'selected' : '' }}>Interest</option>
                <option value="principal" {{ in_array('principal', old('repayment_order', [])) ? 'selected' : '' }}>Principal</option>
            </select>
            <template x-if="showInfo">
                <p class="text-sm text-gray-500 mt-1">Select the order in which repayments will be applied to Penalty, Fees, Interest, and Principal. The first selected item will be prioritized.</p>
            </template>
            @error('repayment_order')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>




<<!-- Automated Payments Section -->
<div x-data="{ open: false, showInfo: false }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-6">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Automated Payments</h3>
        <span x-show="!open" class="text-gray-400">+</span>
        <span x-show="open" class="text-red-400 text-sm">✕</span>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">
        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfoAutoPayments" x-model="showInfo" class="form-checkbox rounded text-blue-600">
            <label for="toggleInfoAutoPayments" class="text-sm text-gray-700">Show field descriptions</label>
        </div>

        <p class="text-sm text-gray-600">
            Choose whether to enable automated payments for this loan product.
        </p>

        <!-- Automated Payments Fields -->
        <div 
            x-data="{ 
                payment_method: '{{ old('payment_method', 'cash') }}',
                auto_payments_enabled: {{ old('auto_payments_enabled', 0) }},
                start_time: '{{ old('start_time', $loanProduct->start_time ?? '') }}',
                end_time: '{{ old('end_time', $loanProduct->end_time ?? '') }}',
            }"
            class="grid grid-cols-1 sm:grid-cols-2 gap-4"
        >
            <!-- Enable Automated Payments -->
            <div>
                <label for="auto_payments_enabled" class="block text-sm font-medium text-gray-700">Enable Automated Payments</label>
                <select 
                    name="auto_payments_enabled" 
                    id="auto_payments_enabled" 
                    class="form-control"
                    x-model="auto_payments_enabled"
                >
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <!-- Start Time (12-hour format) -->
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $loanProduct->start_time ?? '') }}" class="form-control" x-bind:value="start_time">
            </div>

            <!-- End Time (12-hour format) -->
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $loanProduct->end_time ?? '') }}" class="form-control" x-bind:value="end_time">
            </div>

            <!-- Payment Method -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <select 
                    name="payment_method" 
                    id="payment_method" 
                    class="form-control" 
                    x-model="payment_method"
                >
                    <option value="cash">Cash</option>
                    <option value="bank">Bank</option>
                </select>
            </div>

            <!-- Bank Account Dropdown -->
            <div x-show="payment_method === 'bank'" x-cloak>
                <label for="bank_account_id" class="block text-sm font-medium text-gray-700">Select Bank Account</label>
                <select name="bank_account_id" id="bank_account_id" class="form-control">
                    @foreach($bankAccounts as $bankAccount)
                        <option value="{{ $bankAccount->id }}" {{ old('bank_account_id') == $bankAccount->id ? 'selected' : '' }}>
                            {{ $bankAccount->bank_name }} - {{ $bankAccount->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Link to Add/Edit Bank Accounts -->
            <div class="sm:col-span-2">
                <a href="{{ route('bank_accounts.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-md shadow-sm transition">
                    Add / Edit Bank Account
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Extend Loan After Maturity Section -->
<div x-data="{ open: false, showInfo: false, extendEnabled: {{ old('extend_after_maturity', isset($loanProduct) ? $loanProduct->extend_after_maturity : 0) ? 'true' : 'false' }} }" class="border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden mt-6">
    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
        <h3 class="text-lg font-semibold text-gray-800">Extend Loan After Maturity</h3>
        <span x-show="!open" class="text-gray-400">+</span>
        <span x-show="open" class="text-red-400 text-sm">✕</span>
    </div>

    <div x-show="open" x-transition.duration.300ms class="p-4 space-y-6">
        <!-- Toggle Info Checkbox -->
        <div class="flex items-center space-x-2 mb-4">
            <input type="checkbox" id="toggleInfoExtend" x-model="showInfo" class="form-checkbox rounded text-blue-600">
            <label for="toggleInfoExtend" class="text-sm text-gray-700">Show field descriptions</label>
        </div>

        <p class="text-sm text-gray-600">
            Configure what happens to a loan after it reaches maturity without being fully paid.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <!-- Extend After Maturity -->
            <div>
                <label for="extend_after_maturity" class="block text-sm font-medium text-gray-700">Extend Loan After Maturity</label>
                <select
                    name="extend_after_maturity"
                    id="extend_after_maturity"
                    x-model="extendEnabled"
                    class="form-control"
                >
                    <option value="0" {{ old('extend_after_maturity', $loanProduct->extend_after_maturity ?? 0) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('extend_after_maturity', $loanProduct->extend_after_maturity ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">Select 'Yes' to continue applying interest after maturity until fully paid.</p>
                </template>
                @error('extend_after_maturity')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Other Maturity Fields: only active if extension enabled -->

            <!-- Interest Type After Maturity -->
            <div :class="{ 'opacity-50 pointer-events-none': !extendEnabled }">
                <label for="interest_type_after_maturity" class="block text-sm font-medium text-gray-700">Interest Type After Maturity</label>
                <select
                    name="interest_type_after_maturity"
                    id="interest_type_after_maturity"
                    class="form-control"
                    :disabled="!extendEnabled"
                >
                    <option value="" {{ old('interest_type_after_maturity', $loanProduct->interest_type_after_maturity ?? '') == '' ? 'selected' : '' }}>Select Type</option>
                    <option value="percentage" {{ old('interest_type_after_maturity', $loanProduct->interest_type_after_maturity ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed" {{ old('interest_type_after_maturity', $loanProduct->interest_type_after_maturity ?? '') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">Choose whether interest after maturity is a percentage of balance or a fixed amount.</p>
                </template>
                @error('interest_type_after_maturity')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Interest Rate After Maturity -->
            <div :class="{ 'opacity-50 pointer-events-none': !extendEnabled }">
                <label for="interest_rate_after_maturity" class="block text-sm font-medium text-gray-700">Interest Rate After Maturity (%)</label>
                <input
                    type="number"
                    step="0.01"
                    name="interest_rate_after_maturity"
                    id="interest_rate_after_maturity"
                    class="form-control"
                    placeholder="e.g., 5.50"
                    :disabled="!extendEnabled"
                    value="{{ old('interest_rate_after_maturity', $loanProduct->interest_rate_after_maturity ?? '') }}"
                >
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">Enter the interest rate applied after maturity (e.g., 5.50%). Decimals allowed.</p>
                </template>
                @error('interest_rate_after_maturity')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Number of Repayments After Maturity -->
            <div :class="{ 'opacity-50 pointer-events-none': !extendEnabled }">
                <label for="number_of_repayments_after_maturity" class="block text-sm font-medium text-gray-700">Number of Repayments After Maturity</label>
                <input
                    type="number"
                    name="number_of_repayments_after_maturity"
                    id="number_of_repayments_after_maturity"
                    class="form-control"
                    placeholder="e.g., 12 or 0 for unlimited"
                    :disabled="!extendEnabled"
                    value="{{ old('number_of_repayments_after_maturity', $loanProduct->number_of_repayments_after_maturity ?? '') }}"
                >
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">Leave blank or set to 0 for unlimited payments after maturity.</p>
                </template>
                @error('number_of_repayments_after_maturity')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Include Fees After Maturity -->
            <div :class="{ 'opacity-50 pointer-events-none': !extendEnabled }">
                <label for="include_fees_after_maturity" class="block text-sm font-medium text-gray-700">Include Fees After Maturity</label>
                <select
                    name="include_fees_after_maturity"
                    id="include_fees_after_maturity"
                    class="form-control"
                    :disabled="!extendEnabled"
                >
                    <option value="0" {{ old('include_fees_after_maturity', $loanProduct->include_fees_after_maturity ?? 0) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('include_fees_after_maturity', $loanProduct->include_fees_after_maturity ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">Apply recurring fees after maturity if enabled.</p>
                </template>
                @error('include_fees_after_maturity')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Keep Past Maturity Status -->
            <div :class="{ 'opacity-50 pointer-events-none': !extendEnabled }">
                <label for="keep_past_maturity_status" class="block text-sm font-medium text-gray-700">Keep Past Maturity Status</label>
                <select
                    name="keep_past_maturity_status"
                    id="keep_past_maturity_status"
                    class="form-control"
                    :disabled="!extendEnabled"
                >
                    <option value="0" {{ old('keep_past_maturity_status', $loanProduct->keep_past_maturity_status ?? 0) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('keep_past_maturity_status', $loanProduct->keep_past_maturity_status ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                <template x-if="showInfo">
                    <p class="text-sm text-gray-500 mt-1">If 'Yes', loan remains in Past Maturity even after extension.</p>
                </template>
                @error('keep_past_maturity_status')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

        </div>
    </div>
</div>



            <button type="submit" class="btn btn-primary mt-6">Create Loan Product</button>
            </form>

    </div>

    <script>
        document.getElementById('advanced_settings').addEventListener('change', function() {
            const advancedFields = document.getElementById('advanced_fields');
            if (this.checked) {
                advancedFields.style.display = 'block';
            } else {
                advancedFields.style.display = 'none';
            }
        });
    </script>
@endsection
