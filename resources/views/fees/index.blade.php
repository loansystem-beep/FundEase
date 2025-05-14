@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Fees</h1>

        <a href="{{ route('fees.create') }}" class="inline-block mb-4 px-6 py-2 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
            Create New Fee
        </a>

        <!-- Search Bar -->
        <div class="mb-6 flex flex-col md:flex-row justify-center gap-4">
            <input type="text" id="search" class="w-full md:w-1/2 px-6 py-3 border border-gray-300 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by name, category, method" value="{{ $query }}">
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Calculation Method</th>
                        <th class="px-6 py-3">Accounting Method</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fees as $fee)
                        <tr class="border-t">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $fee->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $fee->category)) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($fee->calculation_method) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($fee->accounting_method) }}</td>
                            <td class="px-6 py-4 text-sm flex space-x-2">
                                <a href="{{ route('fees.show', $fee->id) }}" class="inline-block px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                    View
                                </a>
                                <a href="{{ route('fees.edit', $fee->id) }}" class="inline-block px-4 py-2 text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form action="{{ route('fees.destroy', $fee->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $fees->links() }}
    </div>

    <!-- Search functionality using JavaScript -->
    <script>
        document.getElementById('search').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                const name = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
                const category = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                const calculationMethod = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
                const accountingMethod = row.querySelector('td:nth-child(4)').innerText.toLowerCase();
                const match = name.includes(query) || category.includes(query) || calculationMethod.includes(query) || accountingMethod.includes(query);
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
