@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-semibold mb-6 text-center text-blue-600">Borrowers</h1>

    <!-- Single Success Notification -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-md text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Bar & Filters -->
    <div class="mb-6 flex flex-col md:flex-row justify-center gap-4">
        <input type="text" id="search" class="w-full md:w-1/2 px-6 py-3 border border-gray-300 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by name, email, or phone">
        <select id="loanStatusFilter" class="px-4 py-3 border border-gray-300 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Borrowers</option>
            <option value="paid">Fully Paid</option>
            <option value="pending">Pending</option>
        </select>
    </div>

    <!-- Borrowers List -->
    <div class="space-y-4" id="borrowersList">
        @foreach ($borrowers as $borrower)
            <!-- Borrower Card -->
            <div class="borrower-card bg-white p-6 shadow-lg rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleDetails('{{ $borrower->id }}')">
                    <div>
                        <div class="text-xl font-semibold text-gray-800">{{ $borrower->first_name }} {{ $borrower->last_name }}</div>
                        <div class="text-sm text-gray-600 truncate">{{ $borrower->email }}</div>
                    </div>
                    <button class="text-blue-500 hover:underline">View Details</button>
                </div>
                
                <!-- Borrower Details -->
                <div id="details-{{ $borrower->id }}" class="mt-4 hidden transition-all duration-500 ease-in-out opacity-0 transform scale-y-0">
                    <p><strong>Total Loan:</strong> KES {{ number_format($borrower->loans?->sum('amount') ?? 0, 2) }}</p>
                    <p><strong>Outstanding Balance:</strong> KES {{ number_format($borrower->loans?->sum('balance') ?? 0, 2) }}</p>
                    <p><strong>Status:</strong>
                        @if ($borrower->loans && $borrower->loans->sum('balance') == 0)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">Fully Paid</span>
                        @else
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full">Pending</span>
                        @endif
                    </p>
                    <p><strong>Mobile:</strong> {{ $borrower->phone_number }}</p>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('borrowers.show', $borrower) }}" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            View
                        </a>
                        <a href="{{ route('borrowers.edit', $borrower) }}" class="py-2 px-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('borrowers.destroy', $borrower) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this borrower?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                        <a href="{{ route('loans.index', ['borrower_id' => $borrower->id]) }}" class="py-2 px-4 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                            View Loans
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    {{ $borrowers->links() }}
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        let query = this.value.toLowerCase();
        document.querySelectorAll('.borrower-card').forEach(card => {
            let name = card.querySelector('.text-xl').innerText.toLowerCase();
            let email = card.querySelector('.text-sm').innerText.toLowerCase();
            card.style.display = (name.includes(query) || email.includes(query)) ? '' : 'none';
        });
    });

    document.getElementById('loanStatusFilter').addEventListener('change', function () {
        let filter = this.value;
        document.querySelectorAll('.borrower-card').forEach(card => {
            let status = card.querySelector('span')?.innerText.toLowerCase() || '';
            card.style.display = (filter === '' || status.includes(filter)) ? '' : 'none';
        });
    });

    function toggleDetails(borrowerId) {
        let detailsDiv = document.getElementById('details-' + borrowerId);
        detailsDiv.classList.toggle('hidden');
        detailsDiv.classList.toggle('opacity-0');
        detailsDiv.classList.toggle('scale-y-0');
    }
</script>
@endsection
