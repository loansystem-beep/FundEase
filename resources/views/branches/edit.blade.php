@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Branch: {{ $branch->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('branches.update', $branch) }}" method="POST">
        @csrf
        @method('PUT')
        @include('branches._form', ['button' => 'Update Branch'])
    </form>
</div>
@endsection
