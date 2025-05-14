@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Heading -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Bank Accounts</h1>
            <a href="{{ route('banks.create') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-md shadow-sm transition">
                + Add Bank Account
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6">
                <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Bank Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Bank Account Name</th>
                        <th class="px-6 py-3 text-left">Account Name</th>
                        <th class="px-6 py-3 text-left">Currency</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-800">
                    @forelse($banks as $bank)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $bank->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $bank->bank_account_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $bank->account_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $bank->currency }}</td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <a href="{{ route('banks.show', $bank) }}"
                                   class="inline-block text-blue-600 hover:underline">View</a>
                                <a href="{{ route('banks.edit', $bank) }}"
                                   class="inline-block text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('banks.destroy', $bank) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this bank account?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No bank accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
