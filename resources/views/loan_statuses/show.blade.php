@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Loan Status Details</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <div>
            <strong>Name:</strong>
            <span>{{ $loanStatus->name }}</span>
        </div>
        <div>
            <strong>Category:</strong>
            <span class="capitalize">{{ $loanStatus->category }}</span>
        </div>
        <div>
            <strong>System Generated:</strong>
            <span>{{ $loanStatus->is_system_generated ? 'Yes' : 'No' }}</span>
        </div>
        <div>
            <strong>Position:</strong>
            <span>{{ $loanStatus->position }}</span>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('loan-statuses.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-sm px-4 py-2 rounded">
            ← Back to List
        </a>
    </div>
</div>
@endsection
