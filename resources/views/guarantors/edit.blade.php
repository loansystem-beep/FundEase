@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-semibold mb-4">Edit Guarantor</h1>
    <form method="POST" action="{{ route('guarantors.update', $guarantor) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        @include('guarantors.partials.form', ['guarantor' => $guarantor])
        <button type="submit" class="btn btn-primary">Update Guarantor</button>
    </form>
</div>
@endsection
