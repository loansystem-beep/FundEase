@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Full Repayment History</h2>

    <!-- Display success message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Full Repayment History Section -->
    <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Full Repayment History</h3>
        <div class="overflow-x-auto shadow-md rounded-lg bg-white">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="py-2 px-4 text-left">Loan ID</th>
                        <th class="py-2 px-4 text-left">Borrower Name</th>
                        <th class="py-2 px-4 text-left">Amount Paid</th>
                        <th class="py-2 px-4 text-left">Repayment Date</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repayments as $repayment)
                        @php
                            $loan = $repayment->loan; // Get the related loan
                            $borrower = $loan->borrower; // Get the related borrower
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $loan->id }}</td>
                            <td class="py-2 px-4">{{ $borrower->first_name }} {{ $borrower->last_name }}</td>
                            <td class="py-2 px-4">{{ number_format($repayment->amount_paid, 2) }}</td>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($repayment->repayment_date)->format('d-m-Y') }}</td>
                            <td class="py-2 px-4">
                                <span class="inline-block px-3 py-1 text-sm font-medium 
                                            {{ $repayment->status == 'completed' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                    {{ ucfirst($repayment->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-4 flex space-x-2">
                                <a href="{{ route('repayments.show', $repayment->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                                    View
                                </a>
                                <a href="{{ route('repayments.edit', $repayment->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none">
                                    Edit
                                </a>
                                <form action="{{ route('repayments.destroy', $repayment->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none" onclick="return confirm('Are you sure you want to delete this repayment?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
