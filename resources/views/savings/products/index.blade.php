{{-- resources/views/savings/products/index.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Savings Products</h1>
        <a href="{{ route('savings.products.create') }}" class="btn btn-primary mb-3">Create New Product</a>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Interest Rate</th>
                    <th>Interest Type</th>
                    <th>Allow Withdrawals</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->interest_rate }}%</td>
                        <td>{{ $product->interest_type }}</td>
                        <td>{{ $product->allow_withdrawals ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('savings.products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('savings.products.destroy', $product) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
