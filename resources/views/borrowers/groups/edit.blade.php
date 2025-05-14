<!-- resources/views/borrowers/groups/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Borrower Group</h1>
    <p>Edit the details of the selected borrower group.</p>

    <form method="POST" action="{{ route('borrower-groups.update', $group->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="group_name" class="form-label">Group Name</label>
            <input type="text" class="form-control @error('group_name') is-invalid @enderror" id="group_name" name="group_name" value="{{ old('group_name', $group->group_name) }}" required>
            @error('group_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="borrower_ids" class="form-label">Select Borrowers (Max 200 Borrowers)</label>
            <select class="form-select @error('borrower_ids') is-invalid @enderror" id="borrower_ids" name="borrower_ids[]" multiple required>
                @foreach($borrowers as $borrower)
                    <option value="{{ $borrower->id }}" @if(in_array($borrower->id, old('borrower_ids', $group->borrowers->pluck('id')->toArray()))) selected @endif>
                        {{ $borrower->full_name }} - {{ $borrower->id }}
                    </option>
                @endforeach
            </select>
            @error('borrower_ids')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small>Max 200 borrowers allowed in group</small>
        </div>

        <div class="mb-3">
            <label for="group_leader_id" class="form-label">Group Leader</label>
            <select class="form-select @error('group_leader_id') is-invalid @enderror" id="group_leader_id" name="group_leader_id">
                <option value="">Select Leader</option>
                @foreach($borrowers as $borrower)
                    <option value="{{ $borrower->id }}" @if(old('group_leader_id', $group->group_leader_id) == $borrower->id) selected @endif>
                        {{ $borrower->full_name }}
                    </option>
                @endforeach
            </select>
            @error('group_leader_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="loan_officer_id" class="form-label">Loan Officer</label>
            <select class="form-select @error('loan_officer_id') is-invalid @enderror" id="loan_officer_id" name="loan_officer_id">
                <option value="">Select Officer</option>
                @foreach($loanOfficers as $officer)
                    <option value="{{ $officer->id }}" @if(old('loan_officer_id', $group->loan_officer_id) == $officer->id) selected @endif>
                        {{ $officer->name }}
                    </option>
                @endforeach
            </select>
            @error('loan_officer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="collector_name" class="form-label">Collector Name</label>
            <input type="text" class="form-control @error('collector_name') is-invalid @enderror" id="collector_name" name="collector_name" value="{{ old('collector_name', $group->collector_name) }}">
            @error('collector_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="meeting_schedule" class="form-label">Meeting Schedule</label>
            <input type="text" class="form-control @error('meeting_schedule') is-invalid @enderror" id="meeting_schedule" name="meeting_schedule" value="{{ old('meeting_schedule', $group->meeting_schedule) }}">
            @error('meeting_schedule')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $group->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Borrower Group</button>
    </form>
</div>
@endsection
