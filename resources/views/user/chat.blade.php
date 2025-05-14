@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-4">Chat with Admin</h2>

    <div class="card shadow-lg rounded-lg">
        <div class="card-body max-h-[400px] overflow-y-auto p-4" id="chat-box">
            @forelse ($messages as $message)
                <div class="mb-4 text-sm">
                    <!-- Check if the message is sent by the user or admin -->
                    <div class="{{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                        <strong class="{{ $message->sender_id === auth()->id() ? 'bg-blue-100 text-blue-500' : 'text-gray-700' }} inline-block p-2 rounded-lg">
                            {{ $message->sender_id === auth()->id() ? 'You' : 'Admin' }}:
                        </strong>
                        <p class="mt-1 text-gray-800 {{ $message->sender_id === auth()->id() ? 'inline-block bg-blue-100 p-2 rounded-lg' : 'inline-block bg-gray-200 p-2 rounded-lg' }}">
                            {{ $message->message }}
                        </p>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $message->created_at->format('M d, Y h:i A') }}
                    </div>
                </div>
            @empty
                <p class="text-muted text-center text-gray-500">No messages yet. Start the conversation below.</p>
            @endforelse
        </div>
    </div>

    <form action="{{ route('user.chat.send') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group mb-4">
            <textarea name="message" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Type your message..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
            Send
        </button>
    </form>
</div>
@endsection
