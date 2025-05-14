@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Loan Statuses</h1>

    <div class="flex justify-between mb-4">
        <a href="{{ route('loan-statuses.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Add New Loan Status</a>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <input
            type="text"
            id="search"
            placeholder="🔍 Search loan status..."
            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        />
    </div>

    <div id="status-list">
        @foreach ($statuses as $category => $group)
            <div class="mb-6 status-group">
                <h2 class="text-xl font-bold text-gray-900 group-title">{{ ucfirst($category) }}:</h2>
                <ul class="space-y-4">
                    @foreach ($group as $status)
                        <li class="bg-gray-50 p-4 border border-gray-200 rounded-lg flex justify-between items-center status-item">
                            <span class="text-gray-800 status-name">{{ $status->name }}</span>
                            <div class="flex space-x-4">
                                <a href="{{ route('loan-statuses.show', $status) }}" class="text-green-600">View</a>
                                @if (!$status->is_system_generated)
                                    <a href="{{ route('loan-statuses.edit', $status) }}" class="text-blue-600">Edit</a>
                                    <form action="{{ route('loan-statuses.destroy', $status) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this status?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();

        document.querySelectorAll('.status-group').forEach(group => {
            let anyVisible = false;

            group.querySelectorAll('.status-item').forEach(item => {
                const name = item.querySelector('.status-name').innerText.toLowerCase();
                const isMatch = name.includes(term);
                item.style.display = isMatch ? '' : 'none';
                if (isMatch) anyVisible = true;
            });

            // Hide the group heading if none of its statuses are visible
            group.style.display = anyVisible ? '' : 'none';
        });
    });
</script>
@endsection
