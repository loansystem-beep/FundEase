@extends('layouts.app')

@section('content')
<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Guarantors</h1>
        <a href="{{ route('guarantors.create') }}" class="btn btn-primary">Add Guarantor</a>
    </div>

    <table class="min-w-full table-auto border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Country</th>
                <th class="px-4 py-2">Unique #</th>
                <th class="px-4 py-2">Loan Officer</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guarantors as $guarantor)
                <tr>
                    <td class="px-4 py-2">{{ $guarantor->display_name }}</td>
                    <td class="px-4 py-2">{{ $guarantor->country }}</td>
                    <td class="px-4 py-2">{{ $guarantor->unique_number }}</td>
                    <td class="px-4 py-2">{{ optional($guarantor->loanOfficer)->full_name }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('guarantors.show', $guarantor) }}" class="text-blue-500">View</a>
                        <a href="{{ route('guarantors.edit', $guarantor) }}" class="text-yellow-500">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
