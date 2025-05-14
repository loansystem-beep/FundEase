@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Branch</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('branches.store') }}" method="POST">
        @csrf
        @include('branches._form', ['button' => 'Create Branch'])
    </form>
</div>
@endsection
