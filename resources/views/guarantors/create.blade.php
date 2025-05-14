@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-semibold mb-4">Add Guarantor</h1>
    <form method="POST" action="{{ route('guarantors.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @include('guarantors.partials.form')
        <button type="submit" class="btn btn-primary">Save Guarantor</button>
    </form>
</div>
@endsection
