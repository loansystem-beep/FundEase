@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-4">Create Repayment Cycle</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
            <strong>Whoops! Something went wrong:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('repayment_cycles.store') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <label class="block font-semibold">Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name') }}">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Type --}}
        <div class="mb-4">
            <label class="block font-semibold">Type</label>
            <select name="type" id="type" class="w-full border rounded p-2" onchange="toggleFields()">
                <option value="">Select</option>
                <option value="days" {{ old('type') == 'days' ? 'selected' : '' }}>Every X Days</option>
                <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Fixed Monthly Dates</option>
                <option value="weekly" {{ old('type') == 'weekly' ? 'selected' : '' }}>Fixed Weekly Days</option>
            </select>
            @error('type')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Days Field --}}
        <div id="daysField" class="mb-4" style="display: none;">
            <label class="block font-semibold">Every X Days</label>

            <select id="preset_days" class="w-full border rounded p-2 mb-2" onchange="updateDaysInput()">
                <option value="">Select a preset...</option>
                <option value="7">Every 7 Days (Weekly)</option>
                <option value="10">Every 10 Days</option>
                <option value="14">Every 14 Days (Biweekly)</option>
                <option value="15">Every 15 Days</option>
                <option value="30">Every 30 Days (Monthly)</option>
            </select>

            <input type="number" name="every_x_days" id="every_x_days" class="w-full border rounded p-2" placeholder="Or enter custom number" value="{{ old('every_x_days') }}">

            @error('every_x_days')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Monthly Field --}}
        <div id="monthlyField" class="mb-4" style="display: none;">
            <label class="block font-semibold">Select Monthly Dates</label>
            <select name="monthly_dates[]" class="w-full border rounded p-2" multiple>
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}" {{ collect(old('monthly_dates'))->contains($i) ? 'selected' : '' }}>{{ $i }} of every month</option>
                @endfor
            </select>
            @error('monthly_dates')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Weekly Field --}}
        <div id="weeklyField" class="mb-4" style="display: none;">
            <label class="block font-semibold">Select Weekly Days</label>
            <select name="weekly_days[]" class="w-full border rounded p-2" multiple>
                @php
                    $weekDays = [
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                        7 => 'Sunday',
                    ];
                @endphp
                @foreach ($weekDays as $key => $label)
                    <option value="{{ $key }}" {{ collect(old('weekly_days'))->contains($key) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('weekly_days')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>

<script>
    function toggleFields() {
        const type = document.getElementById('type').value;
        document.getElementById('daysField').style.display = (type === 'days') ? 'block' : 'none';
        document.getElementById('monthlyField').style.display = (type === 'monthly') ? 'block' : 'none';
        document.getElementById('weeklyField').style.display = (type === 'weekly') ? 'block' : 'none';
    }

    function updateDaysInput() {
        const presetValue = document.getElementById('preset_days').value;
        if (presetValue) {
            document.getElementById('every_x_days').value = presetValue;
        }
    }

    window.onload = toggleFields;
</script>
@endsection
