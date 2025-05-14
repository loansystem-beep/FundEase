@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg" x-data="{ searchQuery: '' }">

    <!-- Title -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Branches</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add New Branch Button -->
    <a href="{{ route('branches.create') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mb-4">
        Add New Branch
    </a>

    <!-- Real-time Search Bar -->
    <div class="mb-4">
        <input type="text" x-model="searchQuery" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search for a branch..." />
    </div>

    <!-- Branch Table with Real-time Search -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-indigo-600 text-white">
                    <th class="px-6 py-3 text-left text-sm font-medium">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Code</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branches as $branch)
                    <tr x-show="searchQuery === '' || '{{ strtolower($branch->name) }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ strtolower($branch->code) }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ strtolower($branch->location) }}'.toLowerCase().includes(searchQuery.toLowerCase())"
                        class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $branch->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $branch->code }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $branch->location }}</td>
                        <td class="px-6 py-3 text-sm space-x-2">
                            <a href="{{ route('branches.edit', $branch) }}" class="inline-block px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-500">
                                Edit
                            </a>
                            <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="inline-block" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="inline-block px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500" onclick="return confirm('Delete this branch?')">
                                    Delete
                                </button>
                            </form>
                            <a href="{{ route('branches.show', $branch) }}" class="inline-block px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
@endpush
