@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-bold mb-4">Repayment Cycle Details</h1>

    <div class="mb-4">
        <strong>Name:</strong> {{ $repaymentCycle->name }}
    </div>

    <div class="mb-4">
        <strong>Type:</strong> {{ ucfirst($repaymentCycle->type) }}
    </div>

    <div class="mb-4">
        <strong>Details:</strong>
        @if ($repaymentCycle->type === 'days')
            Every {{ $repaymentCycle->every_x_days }} days
        @elseif ($repaymentCycle->type === 'monthly')
            Monthly on: 
            @if (is_array($repaymentCycle->fixed_monthly_dates))
                {{ implode(', ', $repaymentCycle->fixed_monthly_dates) }}
            @else
                {{ $repaymentCycle->fixed_monthly_dates }}
            @endif
        @elseif ($repaymentCycle->type === 'weekly')
            Weekly on:
            @php
                $weekDaysMap = [
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                    7 => 'Sunday',
                ];
                $weekDays = is_array($repaymentCycle->fixed_weekly_days) ? $repaymentCycle->fixed_weekly_days : json_decode($repaymentCycle->fixed_weekly_days, true);
                $labels = collect($weekDays)->map(fn($d) => $weekDaysMap[$d] ?? $d)->toArray();
            @endphp
            {{ implode(', ', $labels) }}
        @endif
    </div>

    <a href="{{ route('repayment_cycles.index') }}" class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Back to List</a>
</div>
@endsection
