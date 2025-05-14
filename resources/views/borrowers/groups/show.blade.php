<!-- resources/views/borrowers/groups/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Borrower Group Details</h1>

    <div class="mb-3">
        <a href="{{ route('borrower-groups.edit', $group->id) }}" class="btn btn-warning">Edit Borrower Group</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>{{ $group->group_name }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Group Leader:</strong> {{ $group->groupLeader->full_name ?? 'N/A' }}</p>
            <p><strong>Loan Officer:</strong> {{ $group->loanOfficer->name ?? 'N/A' }}</p>
            <p><strong>Collector Name:</strong> {{ $group->collector_name ?? 'N/A' }}</p>
            <p><strong>Meeting Schedule:</strong> {{ $group->meeting_schedule ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $group->description ?? 'N/A' }}</p>
            <p><strong>Borrowers:</strong></p>
            <ul>
                @foreach($group->borrowers as $borrower)
                    <li>{{ $borrower->full_name }} - ID: {{ $borrower->id }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
