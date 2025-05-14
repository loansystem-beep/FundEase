@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Loan Products</h1>

    <div class="mb-6">
        <a href="{{ route('loanProducts.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            + Create New Loan Product
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if ($loanProducts->count())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-sm border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Loan Product Name</th>
                        <th class="px-6 py-3 text-left">Default Branch</th>
                        <th class="px-6 py-3 text-left">Auto Payments</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loanProducts as $loanProduct)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loanProduct->name }}</td>
                            <td class="px-6 py-4">{{ $loanProduct->branch?->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                {{ $loanProduct->auto_payments_enabled ? 'Yes' : 'No' }}
                            </td>
                            <td class="px-6 py-4 space-x-4">
                                <a href="{{ route('loanProducts.show', $loanProduct) }}" class="text-green-600 hover:underline">View</a>
                                <a href="{{ route('loanProducts.edit', $loanProduct) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('loanProducts.destroy', $loanProduct) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No loan products found yet.</p>
    @endif
</div>
@endsection
