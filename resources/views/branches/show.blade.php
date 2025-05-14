@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Branch: {{ $branch->name }}</h2>

    <p><strong>Code:</strong> {{ $branch->code }}</p>
    <p><strong>Location:</strong> {{ $branch->location }}</p>
    <p><strong>Currency:</strong> {{ $branch->currency }}</p>
    <p><strong>Country:</strong> {{ $branch->country }}</p>
    <p><strong>Date Format:</strong> {{ $branch->date_format }}</p>
    <p><strong>Address:</strong> {{ $branch->address }}</p>
    <p><strong>Phone:</strong> {{ $branch->phone }}</p>
    <p><strong>Email:</strong> {{ $branch->email }}</p>
    <p><strong>Description:</strong> {{ $branch->description }}</p>

    <a href="{{ route('branches.index') }}" class="btn btn-secondary">Back to Branches</a>
</div>
@endsection
