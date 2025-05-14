@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <form method="POST" aaction="{{ isset($loan) && $loan->id ? route('loans.update', $loan->id) : route('loans.store') }}"

        
        <!-- Include PUT method for updates -->
        @if(isset($loan))
            @method('PUT') <!-- For updating an existing loan -->
        @endif

        <!-- Form inputs will be here -->
        @include('loans._form')

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                {{ isset($loan) ? 'Update Loan' : 'Create Loan' }}
            </button>
        </div>
    </form>
</div>
@endsection
