@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white shadow-xl rounded-xl mt-8">
    <h2 class="text-3xl font-semibold text-gray-800 mb-8">All Expenses</h2>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter and Search Section -->
    <div class="mb-6">
        <form action="{{ route('expenses.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Field -->
            <input type="text" name="search" placeholder="Search by title or description"
                value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">

            <!-- Expense Type Filter -->
            <select name="expense_type" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                <option value="">All Types</option>
                <option value="Type 1" {{ request('expense_type') == 'Type 1' ? 'selected' : '' }}>Type 1</option>
                <option value="Type 2" {{ request('expense_type') == 'Type 2' ? 'selected' : '' }}>Type 2</option>
            </select>

            <!-- Recurring Filter -->
            <select name="is_recurring" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                <option value="">All</option>
                <option value="1" {{ request('is_recurring') == '1' ? 'selected' : '' }}>Recurring</option>
                <option value="0" {{ request('is_recurring') == '0' ? 'selected' : '' }}>Non-recurring</option>
            </select>

            <!-- Date Range Filter -->
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 mt-4 sm:mt-0">
                Filter
            </button>
        </form>
    </div>

    <!-- Add Expense Button -->
    <div class="mb-6 text-right">
        <a href="{{ route('expenses.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
            + Add Expense
        </a>
    </div>

    <!-- Expenses Table -->
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full table-auto text-left border-collapse">
            <thead class="bg-indigo-100 text-indigo-800">
                <tr>
                    <th class="py-3 px-4 text-sm font-semibold">Title</th>
                    <th class="py-3 px-4 text-sm font-semibold">Type</th>
                    <th class="py-3 px-4 text-sm font-semibold">Amount</th>
                    <th class="py-3 px-4 text-sm font-semibold">Date</th>
                    <th class="py-3 px-4 text-sm font-semibold">Loan</th>
                    <th class="py-3 px-4 text-sm font-semibold">Recurring</th>
                    <th class="py-3 px-4 text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($expenses as $expense)
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $expense->title }}</td>
                        <td class="py-3 px-4">{{ $expense->expense_type }}</td>
                        <td class="py-3 px-4">${{ number_format($expense->amount, 2) }}</td>
                        <td class="py-3 px-4">{{ $expense->expense_date?->format('Y-m-d') ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $expense->loan?->id ? '#' . $expense->loan->id : '-' }}</td>
                        <td class="py-3 px-4">{{ $expense->is_recurring ? 'Yes' : 'No' }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('expenses.show', $expense->id) }}" class="text-indigo-600 hover:underline focus:outline-none focus:ring-2 focus:ring-indigo-500">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500">No expenses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $expenses->links() }}
    </div>
</div>
@endsection
