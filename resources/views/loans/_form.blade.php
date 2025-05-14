@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <form method="POST" action="{{ isset($loan) && $loan->id ? route('loans.update', $loan->id) : route('loans.store') }}">
        @csrf

        @if(isset($loan) && $loan->id)
            @method('PUT')
        @endif

  <!-- LOAN INFORMATION SECTION -->
  <div x-data="{ open: true }"
             class="bg-gray-900 bg-opacity-70 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl p-6 mt-12 transition-all hover:shadow-3xl text-white">
            <div @click="open = !open"
                 class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-blue-500 to-teal-500 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
                <h3 class="text-2xl font-semibold">Loan Information</h3>
                <svg :class="{ 'rotate-180': open }" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="open" x-transition class="space-y-6 py-6">

                {{-- Loan Product --}}
                <div class="form-group">
                    <label for="loan_product_id" class="text-lg font-medium">Loan Product</label>
                    <select id="loan_product_id" name="loan_product_id"
                            class="form-control border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-blue-400 transition">
                        @foreach($loanProducts as $product)
                            <option value="{{ $product->id }}"
                                {{ old('loan_product_id', $loan->loan_product_id ?? '') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('loan_product_id')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                    <a href="{{ route('loanProducts.create') }}" class="text-blue-300 hover:underline text-sm">Add/Edit Loan Products</a>
                </div>

                {{-- Borrower --}}
                <div class="form-group">
                    <label for="borrower_id" class="text-lg font-medium">Borrower</label>
                    <select id="borrower_id" name="borrower_id" required
                            class="form-control border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-blue-400 transition">
                        <option value="" disabled {{ old('borrower_id', $loan->borrower_id ?? '') === null ? 'selected' : '' }}>
                            Select a borrower
                        </option>
                        @foreach($borrowers as $borrower)
                            <option value="{{ $borrower->id }}"
                                {{ old('borrower_id', $loan->borrower_id ?? '') == $borrower->id ? 'selected' : '' }}>
                                {{ ucfirst($borrower->first_name) }} {{ ucfirst($borrower->last_name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('borrower_id')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

                {{-- Loan Number --}}
                <div class="form-group">
                    <label for="loan_number" class="text-lg font-medium">Loan #</label>
                    <input id="loan_number" name="loan_number" type="text"
                           class="form-control border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white placeholder-gray-300 focus:ring-2 focus:ring-blue-400 transition"
                           placeholder="Auto-generated or enter manually"
                           value="{{ old('loan_number', $loan->loan_number ?? '') }}">
                    <p class="text-gray-300 text-sm mt-2">Set Custom Loan # if needed. Leave blank for auto-generation.</p>
                    @error('loan_number')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>

<!-- LOAN TERMS SECTION -->
<div x-data="{ open: true }"
             class="bg-amber-900 bg-opacity-70 backdrop-blur-md border border-amber-300 rounded-2xl shadow-2xl p-6 mt-12 transition-all hover:shadow-3xl text-white">
            <div @click="open = !open"
                 class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-amber-500 to-yellow-400 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
                <h3 class="text-2xl font-semibold">Loan Terms (Required)</h3>
                <svg :class="{ 'rotate-180': open }" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="open" x-transition class="space-y-6 py-6">

                <!-- Disbursed By -->
    <div class="form-group">
      <label for="disbursed_by_id" class="text-lg font-medium">Disbursed By</label>
      <select name="disbursed_by_id" id="disbursed_by_id"
              class="form-control border-2 border-amber-300 rounded-lg py-3 px-4 w-full bg-amber-800 text-white focus:outline-none focus:ring-2 focus:ring-amber-400 transition duration-300"
              required>
        @foreach($bankAccounts as $account)
          <option value="{{ $account->id }}"
                  {{ old('disbursed_by_id', $loan->disbursed_by_id ?? '') == $account->id ? 'selected' : '' }}>
            {{ $account->name }}
          </option>
        @endforeach
      </select>
      @error('disbursed_by_id')
        <span class="text-sm text-red-400">{{ $message }}</span>
      @enderror
      @if(Route::has('bankAccounts.create'))
        <a href="{{ route('bankAccounts.create') }}"
           class="text-sm text-yellow-200 hover:text-white hover:underline mt-2 inline-block">
          Add/Edit Disbursed By
        </a>
      @endif
    </div>



                {{-- Principal Amount --}}
                <div class="form-group">
                    <label for="principal_amount" class="text-lg font-medium">Principal Amount</label>
                    <input id="principal_amount" name="principal_amount" type="number" required
                           class="form-control border-2 border-amber-300 rounded-lg py-3 px-4 w-full bg-amber-800 text-white placeholder-amber-300 focus:ring-2 focus:ring-amber-400 transition"
                           placeholder="Enter amount"
                           value="{{ old('principal_amount', $loan->principal_amount ?? '') }}">
                    @error('principal_amount')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

                {{-- Loan Release Date --}}
                <div class="form-group">
                    <label for="loan_release_date" class="text-lg font-medium">Loan Release Date</label>
                    <input id="loan_release_date" name="loan_release_date" type="date" required
                           class="form-control border-2 border-amber-300 rounded-lg py-3 px-4 w-full bg-amber-800 text-white focus:ring-2 focus:ring-amber-400 transition"
                           value="{{ old('loan_release_date', $loan->loan_release_date ?? now()->format('Y-m-d')) }}">
                    @error('loan_release_date')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>


    <!-- INTEREST SECTION -->
    <div x-data="{
                open: false,
                interestMethod: '{{ old('interest_method', $loan->interest_method ?? 'flat') }}',
                interestType:   '{{ old('interest_type',   $loan->interest_type   ?? 'percentage') }}'
            }"
             class="bg-indigo-900 bg-opacity-70 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
            <div @click="open = !open"
                 class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-pink-500 to-purple-700 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
                <h3 class="text-2xl font-semibold">Interest Settings</h3>
                <svg :class="{ 'rotate-180': open }" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="open" x-transition class="space-y-6 py-6">

                {{-- Interest Method --}}
                <div>
                    <label for="interest_method" class="text-lg font-medium">Interest Method</label>
                    <select id="interest_method" name="interest_method" x-model="interestMethod" required
                            class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-pink-400 transition">
                        <option value="flat">Flat Rate</option>
                        <option value="reducing_installment">Reducing Balance – Equal Installment</option>
                        <option value="reducing_principal">Reducing Balance – Equal Principal</option>
                        <option value="interest_only">Interest Only</option>
                        <option value="compound_accrued">Compound Interest – Accrued</option>
                        <option value="compound_installment">Compound Interest – Equal Installment</option>
                    </select>
                    @error('interest_method')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

                {{-- Interest Type (only if Flat) --}}
                <div x-show="interestMethod === 'flat'" x-transition>
                    <label class="text-lg font-medium mb-2 block">Interest Type</label>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="interest_type" value="percentage" x-model="interestType" required
                                   class="form-radio text-pink-500 bg-gray-800 border-gray-600">
                            <span>Percentage % based</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="interest_type" value="fixed" x-model="interestType"
                                   class="form-radio text-pink-500 bg-gray-800 border-gray-600">
                            <span>Fixed amount per cycle</span>
                        </label>
                    </div>
                    @error('interest_type')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

                {{-- Interest Rate --}}
                <div>
                    <label for="interest_rate" class="text-lg font-medium">Rate</label>
                    <div class="flex items-center gap-3">
                        <template x-if="interestMethod === 'flat' && interestType === 'percentage'">
                            <input id="interest_rate" name="interest_rate" type="number" step="0.01" required
                                   placeholder="e.g. 5"
                                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white placeholder-gray-300 focus:ring-2 focus:ring-pink-400 transition"
                                   value="{{ old('interest_rate', $loan->interest_rate ?? '') }}">
                        </template>
                        <template x-if="interestMethod === 'flat' && interestType === 'fixed'">
                            <input id="interest_rate_fixed" name="interest_rate" type="number" step="0.01" required
                                   placeholder="e.g. 2000"
                                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white placeholder-gray-300 focus:ring-2 focus:ring-pink-400 transition"
                                   value="{{ old('interest_rate', $loan->interest_rate ?? '') }}">
                        </template>
                        <template x-if="interestMethod !== 'flat'">
                            <input id="interest_rate_other" name="interest_rate" type="number" step="0.01" required
                                   placeholder="e.g. 5"
                                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white placeholder-gray-300 focus:ring-2 focus:ring-pink-400 transition"
                                   value="{{ old('interest_rate', $loan->interest_rate ?? '') }}">
                        </template>
                        <span class="text-lg font-semibold"
                              x-text="interestMethod === 'flat'
                                        ? (interestType === 'percentage' ? '%' : '₦')
                                        : '%'"></span>
                    </div>
                    @error('interest_rate')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

                {{-- Interest Period --}}
                <div>
                    <label for="interest_period" class="text-lg font-medium">Period</label>
                    <select id="interest_period" name="interest_period" required
                            class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-pink-400 transition">
                        <option value="weekly"  {{ old('interest_period', $loan->interest_period ?? '') == 'weekly'  ? 'selected' : '' }}>Week</option>
                        <option value="monthly" {{ old('interest_period', $loan->interest_period ?? '') == 'monthly' ? 'selected' : '' }}>Month</option>
                        <option value="yearly"  {{ old('interest_period', $loan->interest_period ?? '') == 'yearly'  ? 'selected' : '' }}>Year</option>
                    </select>
                    @error('interest_period')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>



  <!-- DURATION SECTION -->
<div x-data="{
        open: false,
        durationValue: '{{ old('loan_duration_value', $loan->loan_duration_value ?? '') }}',
        durationType:  '{{ old('loan_duration_type',  $loan->loan_duration_type  ?? 'weeks') }}'
    }"
     class="bg-green-900 bg-opacity-70 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
    <div @click="open = !open"
         class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-green-500 to-teal-700 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
        <h3 class="text-2xl font-semibold">Loan Duration</h3>
        <svg :class="{ 'rotate-180': open }" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <div x-show="open" x-transition class="space-y-6 py-6">

        <!-- Duration Value -->
        <div>
            <label for="loan_duration_value" class="text-lg font-medium">Duration Value</label>
            <input id="loan_duration_value" name="loan_duration_value" type="number" min="1"
                   x-model="durationValue" required
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white placeholder-gray-300 focus:ring-2 focus:ring-green-400 transition"
                   placeholder="e.g. 12">
            @error('loan_duration_value')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Duration Type -->
        <div>
            <label for="loan_duration_type" class="text-lg font-medium">Duration Type</label>
            <select id="loan_duration_type" name="loan_duration_type"
                    x-model="durationType" required
                    class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-green-400 transition">
                <option value="weeks"  :selected="durationType === 'weeks'">Weeks</option>
                <option value="months" :selected="durationType === 'months'">Months</option>
                <option value="years"  :selected="durationType === 'years'">Years</option>
            </select>
            @error('loan_duration_type')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

    </div>
</div>

<!-- REPAYMENT SECTION -->
<div x-data="{ open: false }"
     class="bg-blue-900 bg-opacity-70 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
    <div @click="open = !open"
         class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-700 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
        <h3 class="text-2xl font-semibold">Repayment Settings</h3>
        <svg :class="{ 'rotate-180': open }" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <div x-show="open" x-transition class="space-y-6 py-6">

        {{-- Repayment Cycle --}}
        <div>
            <label for="repayment_cycle_id" class="text-lg font-medium">Repayment Cycle</label>
            <select id="repayment_cycle_id" name="repayment_cycle_id" required
                    class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-indigo-400 transition">
                <option value="">-- Select Cycle --</option>
                @foreach($repaymentCycles as $cycle)
                    <option value="{{ $cycle->id }}" {{ old('repayment_cycle_id', $loan->repayment_cycle_id ?? '') == $cycle->id ? 'selected' : '' }}>
                        {{ $cycle->name }}
                    </option>
                @endforeach
            </select>
            @error('repayment_cycle_id')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Number of Repayments --}}
        <div>
            <label for="number_of_repayments" class="text-lg font-medium">Number of Repayments</label>
            <input id="number_of_repayments" name="number_of_repayments" type="number" min="1" required
                   value="{{ old('number_of_repayments', $loan->number_of_repayments ?? '') }}"
                   placeholder="e.g. 12"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white placeholder-gray-300 focus:ring-2 focus:ring-indigo-400 transition">
            @error('number_of_repayments')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

    </div>
</div>



<!-- OPTIONAL LOAN TERMS SECTION -->
<div x-data="{
        open: false,
        decimalPlaces: '{{ old('decimal_places', $loan->decimal_places ?? '2') }}',
        roundOffInterest: {{ old('round_up_off_interest', $loan->round_up_off_interest ?? false) ? 'true' : 'false' }},
        interestStartDate: '{{ old('interest_start_date', $loan->interest_start_date ?? '') }}',
        firstRepaymentDate: '{{ old('first_repayment_date', $loan->first_repayment_date ?? '') }}',
        proRataFirst: {{ old('pro_rata_first_repayment', $loan->pro_rata_first_repayment ?? false) ? 'true' : 'false' }},
        adjustFeesFirst: {{ old('adjust_fees_first_repayment', $loan->adjust_fees_first_repayment ?? false) ? 'true' : 'false' }},
        freezeRemaining: {{ old('do_not_adjust_remaining_repayments', $loan->do_not_adjust_remaining_repayments ?? false) ? 'true' : 'false' }},
        firstRepaymentAmount: '{{ old('first_repayment_amount', $loan->first_repayment_amount ?? '') }}',
        lastRepaymentAmount: '{{ old('last_repayment_amount', $loan->last_repayment_amount ?? '') }}',
        overrideMaturityDate: '{{ old('override_maturity_date', $loan->override_maturity_date ?? '') }}',
        overrideEachRepayment: '{{ old('override_each_repayment_amount', $loan->override_each_repayment_amount ?? '') }}',
        proRataEach: '{{ old('calculate_interest_pro_rata', $loan->calculate_interest_pro_rata ?? false) }}',
        interestMethod: '{{ old('interest_charge_method', $loan->interest_charge_method ?? 'normal') }}',
        interestN: '{{ old('skip_interest_first_n_repayments', $loan->skip_interest_first_n_repayments ?? '') }}',
        principalMethod: '{{ old('principal_charge_method', $loan->principal_charge_method ?? 'normal') }}',
        principalN: '{{ old('skip_principal_first_n_repayments', $loan->skip_principal_first_n_repayments ?? '') }}',
        balloonAmount: '{{ old('balloon_repayment_amount', $loan->balloon_repayment_amount ?? '') }}',
        moveFirstDays: '{{ old('move_first_repayment_days', $loan->move_first_repayment_days ?? '') }}',
    }"
     class="bg-purple-900 bg-opacity-70 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl p-6 mt-8 transition-all hover:shadow-3xl text-white">
    <div @click="open = !open"
         class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-700 cursor-pointer rounded-xl hover:bg-gradient-to-l transition-all ease-in-out">
        <h3 class="text-2xl font-semibold">Optional Terms & Schedule</h3>
        <svg :class="{ 'rotate-180': open }" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <div x-show="open" x-transition class="space-y-6 py-6">

        <!-- Decimal Places -->
        <div>
            <label for="decimal_places" class="text-lg font-medium">Decimal Places</label>
            <select id="decimal_places" name="decimal_places" x-model="decimalPlaces" required
                    class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition">
                <option value="0">0 (Integer)</option>
                <option value="1">1 Decimal Place</option>
                <option value="2">2 Decimal Places</option>
                <option value="3">3 Decimal Places</option>
            </select>
            @error('decimal_places')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Round Up/Off Interest -->
        <div class="flex items-center space-x-2">
            <input id="round_up_off_interest" name="round_up_off_interest" type="checkbox" x-model="roundOffInterest"
                   class="h-5 w-5 text-purple-600 bg-gray-800 border-gray-600 rounded focus:ring-purple-400 transition">
            <label for="round_up_off_interest" class="text-lg font-medium">Round Up/Off Interest for All Repayments</label>
        </div>
        @error('round_up_off_interest')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror

        <!-- Interest Start Date -->
        <div>
            <label for="interest_start_date" class="text-lg font-medium">Interest Start Date</label>
            <input id="interest_start_date" name="interest_start_date" type="date" x-model="interestStartDate"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition">
            @error('interest_start_date')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- First Repayment Date -->
        <div>
            <label for="first_repayment_date" class="text-lg font-medium">First Repayment Date</label>
            <input id="first_repayment_date" name="first_repayment_date" type="date" x-model="firstRepaymentDate"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition">
            @error('first_repayment_date')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Calculate First on Pro-Rata -->
        <div class="flex items-center space-x-2">
            <input id="pro_rata_first_repayment" name="pro_rata_first_repayment" type="checkbox" x-model="proRataFirst"
                   class="h-5 w-5 text-purple-600 bg-gray-800 border-gray-600 rounded focus:ring-purple-400 transition">
            <label for="pro_rata_first_repayment" class="text-lg font-medium">Calculate First Repayment on Pro-Rata Basis</label>
        </div>

        <!-- Adjust Fees First Pro-Rata -->
        <div class="flex items-center space-x-2">
            <input id="adjust_fees_first_repayment" name="adjust_fees_first_repayment" type="checkbox" x-model="adjustFeesFirst"
                   class="h-5 w-5 text-purple-600 bg-gray-800 border-gray-600 rounded focus:ring-purple-400 transition">
            <label for="adjust_fees_first_repayment" class="text-lg font-medium">Adjust Fees in First Repayment on Pro-Rata Basis</label>
        </div>

        <!-- Do Not Adjust Remaining -->
        <div class="flex items-center space-x-2">
            <input id="do_not_adjust_remaining_repayments" name="do_not_adjust_remaining_repayments" type="checkbox" x-model="freezeRemaining"
                   class="h-5 w-5 text-purple-600 bg-gray-800 border-gray-600 rounded focus:ring-purple-400 transition">
            <label for="do_not_adjust_remaining_repayments" class="text-lg font-medium">Do Not Adjust Remaining Repayments (Flat-Rate & Interest-Only)</label>
        </div>

        <!-- First Repayment Amount -->
        <div>
            <label for="first_repayment_amount" class="text-lg font-medium">First Repayment Amount</label>
            <input id="first_repayment_amount" name="first_repayment_amount" type="number" step="0.01" x-model="firstRepaymentAmount"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition"
                   placeholder="e.g. 200.00">
            @error('first_repayment_amount')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Last Repayment Amount -->
        <div>
            <label for="last_repayment_amount" class="text-lg font-medium">Last Repayment Amount</label>
            <input id="last_repayment_amount" name="last_repayment_amount" type="number" step="0.01" x-model="lastRepaymentAmount"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition"
                   placeholder="e.g. 200.00">
            @error('last_repayment_amount')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Override Maturity Date -->
        <div>
            <label for="override_maturity_date" class="text-lg font-medium">Override Maturity Date</label>
            <input id="override_maturity_date" name="override_maturity_date" type="date" x-model="overrideMaturityDate"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition">
            @error('override_maturity_date')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Override Each Repayment Amount -->
        <div>
            <label for="override_each_repayment_amount" class="text-lg font-medium">Override Each Repayment Amount</label>
            <input id="override_each_repayment_amount" name="override_each_repayment_amount" type="number" step="0.01" x-model="overrideEachRepayment"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition"
                   placeholder="e.g. 150.00">
            @error('override_each_repayment_amount')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Pro-Rata Interest Each Repayment -->
        <div>
            <label for="calculate_interest_pro_rata" class="text-lg font-medium">Calculate Interest in Each Repayment on Pro-Rata Basis?</label>
            <select id="calculate_interest_pro_rata" name="calculate_interest_pro_rata" x-model="proRataEach" required
                    class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
            @error('calculate_interest_pro_rata')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Interest Charging Method -->
        <div>
            <label for="interest_charge_method" class="text-lg font-medium">How should Interest be charged in Loan Schedule?</label>
            <select id="interest_charge_method" name="interest_charge_method" x-model="interestMethod" required
                    class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition">
                <option value="normal">Include interest normally as per Interest Method</option>
                <option value="released_date">Charge All Interest on the Released Date</option>
                <option value="first_repayment">Charge All Interest on the First Repayment</option>
                <option value="last_repayment">Charge All Interest on the Last Repayment</option>
                <option value="no_interest_last_repayment">Do Not Charge Interest on the Last Repayment</option>
                <option value="no_interest_first_n_repayments">Do Not Charge Interest on the First [n] Repayment(s)</option>
            </select>
            @error('interest_charge_method')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror

            <!-- Number of Repayments for Interest Exclusion -->
            <div x-show="interestMethod === 'no_interest_first_n_repayments'" x-transition class="mt-4">
                <label for="skip_interest_first_n_repayments" class="text-lg font-medium">Exclude interest for first</label>
                <input id="skip_interest_first_n_repayments" name="skip_interest_first_n_repayments" type="number" min="1" x-model="interestN"
                       class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition"
                       placeholder="e.g. 2">
                @error('skip_interest_first_n_repayments')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Principal Charging Method -->
        <div>
            <label for="principal_charge_method" class="text-lg font-medium">How should Principal be charged in Loan Schedule?</label>
            <select id="principal_charge_method" name="principal_charge_method" x-model="principalMethod" required
                    class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition">
                <option value="normal">Include principal normally as per Interest Method</option>
                <option value="released_date">Charge All Principal on the Released Date</option>
                <option value="first_repayment">Charge All Principal on the First Repayment</option>
                <option value="last_repayment">Charge All Principal on the Last Repayment</option>
                <option value="no_principal_last_repayment">Do Not Charge Principal on the Last Repayment</option>
                <option value="no_principal_first_n_repayments">Do Not Charge Principal on the First [n] Repayment(s)</option>
            </select>
            @error('principal_charge_method')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror

            <!-- Number of Repayments for Principal Exclusion -->
            <div x-show="principalMethod === 'no_principal_first_n_repayments'" x-transition class="mt-4">
                <label for="skip_principal_first_n_repayments" class="text-lg font-medium">Exclude principal for first</label>
                <input id="skip_principal_first_n_repayments" name="skip_principal_first_n_repayments" type="number" min="1" x-model="principalN"
                       class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition"
                       placeholder="e.g. 2">
                @error('skip_principal_first_n_repayments')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Balloon Repayment Amount -->
        <div>
            <label for="balloon_repayment_amount" class="text-lg font-medium">Balloon Repayment Amount</label>
            <input id="balloon_repayment_amount" name="balloon_repayment_amount" type="number" step="0.01" x-model="balloonAmount"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition"
                   placeholder="e.g. 500.00">
            @error('balloon_repayment_amount')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Move First Repayment Days -->
        <div>
            <label for="move_first_repayment_days" class="text-lg font-medium">Move First Repayment if days from release &lt; </label>
            <input id="move_first_repayment_days" name="move_first_repayment_days" type="number" min="0" x-model="moveFirstDays"
                   class="border-2 border-white/50 rounded-lg py-3 px-4 w-full bg-gray-800 text-white focus:ring-2 focus:ring-purple-400 transition"
                   placeholder="e.g. 5">
            @error('move_first_repayment_days')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
        </div>

    </div>
</div>



                <!-- Submit Button -->
                <div class="mt-10 flex justify-center">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-lg shadow-xl transition transform hover:scale-105">
                {{ ! empty($loan) && $loan->id ? 'Update Loan' : 'Create Loan' }}
            </button>
        </div>
    </form>
</div>
@endsection

