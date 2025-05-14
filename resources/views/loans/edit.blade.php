@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Loan</h2>
    <form method="POST" action="{{ route('loans.update', $loan) }}">
        @method('PUT')
        @include('loans._form') <!-- This includes the form from _form.blade.php -->
    </form>
</div>
@endsection
