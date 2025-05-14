@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-semibold mb-6 text-center text-blue-600">Bank Accounts</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-md text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="mb-6 flex flex-col md:flex-row justify-center gap-4">
        <input type="text" id="search" class="w-full md:w-1/2 px-6 py-3 border border-gray-300 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by name, bank, or currency" value="{{ $query }}">
        <select id="statusFilter" class="px-4 py-3 border border-gray-300 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Accounts</option>
            <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <!-- Bank Account Cards -->
    <div class="space-y-4" id="accountList">
        @foreach ($bankAccounts as $account)
            <div class="account-card bg-white p-6 shadow-lg rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleDetails('{{ $account->id }}')">
                    <div>
                        <div class="text-xl font-semibold text-gray-800">{{ $account->name }}</div>
                        <div class="text-sm text-gray-600 truncate">{{ $account->bank_name }} • {{ $account->currency }}</div>
                    </div>
                    <button class="text-blue-500 hover:underline">View Details</button>
                </div>

                <div id="details-{{ $account->id }}" class="mt-4 hidden transition-all duration-500 ease-in-out opacity-0 transform scale-y-0">
                    <p><strong>Account Number:</strong> {{ $account->account_number ?? '—' }}</p>
                    <p><strong>SWIFT Code:</strong> {{ $account->swift_code ?? '—' }}</p>
                    <p><strong>Balance:</strong> {{ number_format($account->balance, 2) }}</p>
                    <p><strong>Status:</strong>
                        @if ($account->is_active)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full">Inactive</span>
                        @endif
                    </p>

                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('bank_accounts.show', $account) }}" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">View</a>
                        <a href="{{ route('bank_accounts.edit', $account) }}" class="py-2 px-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('bank_accounts.destroy', $account) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this bank account?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $bankAccounts->links() }}
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.account-card').forEach(card => {
            const name = card.querySelector('.text-xl').innerText.toLowerCase();
            const bank = card.querySelector('.text-sm').innerText.toLowerCase();
            card.style.display = (name.includes(query) || bank.includes(query)) ? '' : 'none';
        });
    });

    document.getElementById('statusFilter').addEventListener('change', function () {
        const filter = this.value;
        document.querySelectorAll('.account-card').forEach(card => {
            const statusSpan = card.querySelector('span.bg-green-500, span.bg-red-500');
            const status = statusSpan?.innerText.toLowerCase() || '';
            card.style.display = (filter === '' || status.includes(filter)) ? '' : 'none';
        });
    });

    function toggleDetails(accountId) {
        const detailsDiv = document.getElementById('details-' + accountId);
        detailsDiv.classList.toggle('hidden');
        detailsDiv.classList.toggle('opacity-0');
        detailsDiv.classList.toggle('scale-y-0');
    }
</script>
@endsection
