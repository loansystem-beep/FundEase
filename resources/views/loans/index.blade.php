@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
        <h1 class="text-2xl font-bold text-gray-800">📋 Loans</h1>
        <a href="{{ route('loans.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" />
            </svg>
            New Loan
        </a>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" id="loanSearch" placeholder="🔍 Search loans..." class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200" id="loanTable">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Loan #</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Borrower</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Release Date</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($loans as $loan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loan->loan_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        @if($loan->borrower)
                            {{ ucfirst($loan->borrower->first_name) }} {{ ucfirst($loan->borrower->last_name) }}
                        @else
                            <span class="text-red-500 italic">No borrower</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $loan->loanProduct->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($loan->principal_amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ \Carbon\Carbon::parse($loan->loan_release_date)->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-right space-x-2">
                        <a href="{{ route('loans.show', $loan) }}" class="inline-block text-blue-600 hover:text-blue-800" title="View">
                            👁️
                        </a>
                        <a href="{{ route('loans.edit', $loan) }}" class="inline-block text-yellow-500 hover:text-yellow-700" title="Edit">
                            ✏️
                        </a>
                        <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this loan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No loans found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Live Search Script -->
<script>
document.getElementById('loanSearch').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#loanTable tbody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
