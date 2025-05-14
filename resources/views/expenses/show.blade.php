<!-- resources/views/expenses/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Expense Details</h1>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Title</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm font-medium text-gray-700">Title</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $expense->title }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm font-medium text-gray-700">Amount</td>
                            <td class="px-4 py-2 text-sm text-gray-900">${{ number_format($expense->amount, 2) }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm font-medium text-gray-700">Expense Type</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $expense->expense_type }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm font-medium text-gray-700">Description</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $expense->description ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm font-medium text-gray-700">Expense Date</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ \Carbon\Carbon::parse($expense->expense_date)->format('F j, Y') }}</td>
                        </tr>
                        <!-- Add other fields as necessary -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('expenses.index') }}" class="inline-block px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md transition duration-300 ease-in-out">
                Back to Expenses
            </a>
        </div>
    </div>
@endsection
