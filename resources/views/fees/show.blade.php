@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">

    <!-- Search Bar -->
    <div class="mb-6 flex justify-center">
        <input type="text" id="search" placeholder="Search by name or type..."
            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" />
    </div>

    <!-- Add Repayment Cycle Button -->
    <a href="{{ route('repayment_cycles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Add Repayment Cycle
    </a>

    <!-- Table for Repayment Cycles -->
    <table class="table-auto w-full mt-6 border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Type</th>
                <th class="px-4 py-2 text-left">Details</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody id="cycleList">
            @foreach($repaymentCycles as $cycle)
                <tr class="border-t border-gray-200">
                    <td class="px-4 py-2 cycle-name">{{ $cycle->name }}</td>
                    <td class="px-4 py-2 cycle-type">{{ ucfirst($cycle->type) }}</td>
                    <td class="px-4 py-2">
                        @if ($cycle->type === 'days')
                            Every {{ $cycle->every_x_days }} days
                        @elseif ($cycle->type === 'monthly')
                            Monthly on:
                            @if (is_array($cycle->monthly_dates))
                                {{ implode(', ', $cycle->monthly_dates) }}
                            @else
                                {{ $cycle->monthly_dates }}
                            @endif
                        @elseif ($cycle->type === 'weekly')
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
                                $weekDays = is_array($cycle->weekly_days) ? $cycle->weekly_days : json_decode($cycle->weekly_days, true);
                                $labels = collect($weekDays)->map(fn($d) => $weekDaysMap[$d] ?? $d)->toArray();
                            @endphp
                            {{ implode(', ', $labels) }}
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('repayment_cycles.show', $cycle->id) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('repayment_cycles.edit', $cycle->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('repayment_cycles.destroy', $cycle->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this repayment cycle?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $repaymentCycles->appends(['search' => request('search')])->links() }}
    </div>

</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('#cycleList tr').forEach(row => {
            const name = row.querySelector('.cycle-name').innerText.toLowerCase();
            const type = row.querySelector('.cycle-type').innerText.toLowerCase();
            row.style.display = (name.includes(query) || type.includes(query)) ? '' : 'none';
        });
    });
</script>

@endsection
