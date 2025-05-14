@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Collateral Register</h1>
        <a href="{{ route('collaterals.create') }}"
           class="inline-block px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md shadow">
            + Add New Collateral
        </a>
    </div>

    <!-- Real-time Search & Filters -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" id="searchInput" placeholder="Search by name, type, borrower..."
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">

        <select id="statusFilter"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="seized">Seized</option>
        </select>
    </div>

    <!-- Collateral Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50 text-left text-sm text-gray-700 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 border-b">#</th>
                    <th class="px-4 py-3 border-b">Name</th>
                    <th class="px-4 py-3 border-b">Type</th>
                    <th class="px-4 py-3 border-b">Value</th>
                    <th class="px-4 py-3 border-b">Borrower</th>
                    <th class="px-4 py-3 border-b">Status</th>
                    <th class="px-4 py-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800" id="collateralTable">
                @forelse ($collaterals as $collateral)
                    <tr class="hover:bg-gray-50 collateral-row">
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $collateral->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $collateral->type }}</td>
                        <td class="px-4 py-2 border-b">{{ number_format($collateral->value, 2) }}</td>
                        <td class="px-4 py-2 border-b">
                            {{ $collateral->borrower->first_name ?? '' }} {{ $collateral->borrower->last_name ?? '' }}
                        </td>
                        <td class="px-4 py-2 border-b capitalize status">
                            <span class="inline-block px-2 py-1 text-xs rounded 
                                {{ $collateral->status == 'active' ? 'bg-green-100 text-green-800' : 
                                   ($collateral->status == 'inactive' ? 'bg-red-100 text-red-800' : 
                                   'bg-yellow-100 text-yellow-800') }}">
                                {{ $collateral->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border-b space-x-2">
                            <a href="{{ route('collaterals.show', $collateral->id) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                            <a href="{{ route('collaterals.edit', $collateral->id) }}"
                               class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Edit</a>
                            <form action="{{ route('collaterals.destroy', $collateral->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this collateral?')"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No collaterals found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Real-time Filter Script -->
<script>
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('#collateralTable .collateral-row');

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();

        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            const rowStatus = row.querySelector('.status')?.innerText.toLowerCase();

            const matchesSearch = rowText.includes(search);
            const matchesStatus = !status || rowStatus.includes(status);

            row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterRows);
    statusFilter.addEventListener('change', filterRows);
</script>
@endsection
