<!-- resources/views/borrowers/groups/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Borrower Groups</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('borrower-groups.create') }}" class="btn btn-primary">Add Borrower Group</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Group Name</th>
                <th>Group Leader</th>
                <th>Loan Officer</th>
                <th>Borrowers Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
                <tr>
                    <td>{{ $group->group_name }}</td>
                    <td>{{ $group->groupLeader->full_name ?? 'N/A' }}</td>
                    <td>{{ $group->loanOfficer->name ?? 'N/A' }}</td>
                    <td>{{ $group->borrowers->count() }}</td>
                    <td>
                        <a href="{{ route('borrower-groups.edit', $group->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('borrower-groups.destroy', $group->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $groups->links() }}
</div>
@endsection
