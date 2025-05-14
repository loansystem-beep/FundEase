@extends('layouts.app')

@section('content')
<div class="flex h-[80vh] max-w-6xl mx-auto shadow-lg rounded-lg overflow-hidden">
    <!-- Sidebar with Users -->
    <div class="w-1/3 bg-gray-100 p-4 overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Users</h2>
        <form action="{{ route('admin.command.chat', ['userId' => $user->id]) }}" method="GET">
            <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search users..."
                class="w-full p-2 mb-4 rounded border border-gray-300 focus:ring focus:ring-blue-400">
        </form>

        @foreach($users as $userItem)
            @if($userItem->id !== auth()->id())
                <div class="flex items-center justify-between mb-3 cursor-pointer p-3 bg-white hover:bg-blue-50 rounded shadow"
                    onclick="window.location='{{ route('admin.command.chat', ['userId' => $userItem->id]) }}'">
                    <div>
                        <p class="font-semibold text-gray-700">{{ $userItem->name }}</p>
                        <p class="text-sm text-gray-500">{{ $userItem->email }}</p>
                    </div>
                    <span class="text-blue-600">Chat</span>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Chat Section -->
    <div class="w-2/3 bg-white flex flex-col">
        <div class="border-b px-6 py-4 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-700">Chat with {{ $user->name }}</h3>
        </div>

        <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-100" id="chat-box">
            @if($messages && $messages->count())
                @foreach ($messages as $message)
                    <div class="flex {{ $message->sender_id === $adminId ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs md:max-w-md px-4 py-2 rounded-xl {{ $message->sender_id === $adminId ? 'bg-blue-500 text-white' : 'bg-white text-gray-800 border border-gray-300' }}">
                            <p class="text-sm">{{ $message->message }}</p>
                            <div class="text-xs text-right mt-1 text-gray-300">
                                {{ $message->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-gray-500">No messages yet. Start the conversation below.</p>
            @endif
        </div>

        <!-- Message Input -->
        <form action="{{ route('admin.command.chat.send') }}" method="POST" class="p-4 border-t bg-white">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <div class="flex space-x-2">
                <input type="text" name="message" required placeholder="Type a message..."
                    class="flex-1 p-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition">Send</button>
            </div>
        </form>

        @if(session('status'))
            <div class="p-3 text-center bg-green-500 text-white">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>
@endsection
