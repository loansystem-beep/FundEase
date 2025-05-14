@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-2">Admin Command Dashboard</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Manage Users -->
        <a href="{{ route('admin.command.manage_users') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-2xl shadow-md transition-all duration-300 flex items-center justify-center space-x-4 group">
            <i class="fas fa-users text-2xl group-hover:scale-110 transform"></i>
            <span class="font-semibold text-lg">Manage Users</span>
        </a>

        <!-- Chat with User -->
        <a href="{{ route('admin.command.chat', ['userId' => 1]) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-2xl shadow-md transition-all duration-300 flex items-center justify-center space-x-4 group">
            <i class="fas fa-comments text-2xl group-hover:scale-110 transform"></i>
            <span class="font-semibold text-lg">Chat with User</span>
        </a>

        <!-- Add more command cards here if needed -->
        {{-- Example --}}
        {{-- 
        <a href="#" class="bg-green-600 hover:bg-green-700 text-white p-6 rounded-2xl shadow-md transition-all duration-300 flex items-center justify-center space-x-4 group">
            <i class="fas fa-cogs text-2xl group-hover:scale-110 transform"></i>
            <span class="font-semibold text-lg">System Settings</span>
        </a>
        --}}
    </div>
</div>
@endsection
