@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-900">Disbursers</h1>
        <a href="{{ route('disbursers.create') }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            + Create New Disburser
        </a>
    </div>

    {{-- Instant Search Bar --}}
    <div class="mb-6">
        <input
            type="text"
            id="search"
            placeholder="🔍 Search by name or description..."
            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        />
    </div>

    <div class="overflow-hidden shadow-sm sm:rounded-lg bg-white">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Description</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody id="disbursers">
                @foreach($disbursers as $disburser)
                    <tr class="border-t disburser-row">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 disburser-name">
                            {{ $disburser->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 disburser-description">
                            {{ $disburser->description ?? 'No description' }}
                        </td>
                        <td class="px-6 py-4 text-sm space-x-4">
                            <a href="{{ route('disbursers.show', $disburser->id) }}" class="text-green-600 hover:text-green-900">View</a>
                            <a href="{{ route('disbursers.edit', $disburser->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="{{ route('disbursers.destroy', $disburser->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this disburser?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($disbursers->isEmpty())
            <div class="text-center py-6 text-gray-500">No disbursers found.</div>
        @endif
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        document.querySelectorAll('.disburser-row').forEach(row => {
            const name = row.querySelector('.disburser-name').innerText.toLowerCase();
            const desc = row.querySelector('.disburser-description').innerText.toLowerCase();
            row.style.display = (name.includes(term) || desc.includes(term)) ? '' : 'none';
        });
    });
</script>
@endsection
