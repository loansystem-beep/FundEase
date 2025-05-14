@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Repayment Cycles</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Instant Search Bar -->
    <div class="mb-6">
        <input
            type="text"
            id="search"
            placeholder="🔍 Search by name or type..."
            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        />
    </div>

    <a href="{{ route('repayment_cycles.create') }}"
       class="inline-block mb-4 px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
        + Add Repayment Cycle
    </a>

    <table class="table-auto w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Type</th>
                <th class="px-4 py-2 text-left">Details</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody id="cycles">
            @foreach($repaymentCycles as $cycle)
                <tr class="border-t cycle-row">
                    <td class="px-4 py-2 cycle-name">{{ $cycle->name }}</td>
                    <td class="px-4 py-2 cycle-type">{{ ucfirst($cycle->type) }}</td>
                    <td class="px-4 py-2">
                        @if ($cycle->type === 'days')
                            Every {{ $cycle->every_x_days }} days
                        @elseif ($cycle->type === 'monthly')
                            Monthly on:
                            @php
                                $dates = is_array($cycle->monthly_dates) ? $cycle->monthly_dates : (is_string($cycle->monthly_dates) ? json_decode($cycle->monthly_dates, true) : []);
                            @endphp
                            {{ implode(', ', $dates) }}
                        @elseif ($cycle->type === 'weekly')
                            Weekly on:
                            @php
                                $weekDaysMap = [1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat',7=>'Sun'];
                                $days = is_array($cycle->weekly_days) ? $cycle->weekly_days : (is_string($cycle->weekly_days) ? json_decode($cycle->weekly_days, true) : []);
                                $labels = collect($days)->map(fn($d) => $weekDaysMap[$d] ?? $d)->toArray();
                            @endphp
                            {{ implode(', ', $labels) }}
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('repayment_cycles.show', $cycle) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('repayment_cycles.edit', $cycle) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('repayment_cycles.destroy', $cycle) }}" method="POST" class="inline" onsubmit="return confirm('Delete this cycle?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Server-side pagination (optional) -->
    <div class="mt-6">
        {{ $repaymentCycles->links() }}
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        document.querySelectorAll('.cycle-row').forEach(row => {
            const name = row.querySelector('.cycle-name').innerText.toLowerCase();
            const type = row.querySelector('.cycle-type').innerText.toLowerCase();
            row.style.display = (name.includes(term) || type.includes(term)) ? '' : 'none';
        });
    });
</script>
@endsection
