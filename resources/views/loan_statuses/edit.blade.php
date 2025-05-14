@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-8 bg-white shadow-lg rounded-lg">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Loan Status</h1>
        <a href="{{ route('loan-statuses.index') }}" class="text-blue-600 hover:underline">← Return to List</a>
    </div>

    <form method="POST" action="{{ route('loan-statuses.update', $loanStatus) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Status Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $loanStatus->name) }}"
                   class="form-input mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category Dropdown -->
        <div class="mb-4">
            <label for="category_select" class="block text-sm font-medium text-gray-700">Category</label>
            <select id="category_select"
                    name="category_select"
                    class="form-select mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @php
                    $currentCategory = old('category', $loanStatus->category);
                    $isCustom = !in_array($currentCategory, $categories->toArray());
                @endphp

                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ $currentCategory === $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
                <option value="__other__" {{ $isCustom ? 'selected' : '' }}>Other (specify below)</option>
            </select>
        </div>

        <!-- Custom Category Input -->
        <div class="mb-4" id="custom_category_input" style="{{ $isCustom ? '' : 'display: none;' }}">
            <label for="category" class="block text-sm font-medium text-gray-700">Custom Category</label>
            <input type="text" id="category" name="category"
                   value="{{ $isCustom ? $currentCategory : '' }}"
                   class="form-input mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('category')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- System Generated (read-only display) -->
        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" disabled
                       class="rounded border-gray-300 text-blue-600"
                       {{ $loanStatus->is_system_generated ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-500">System Generated (Not Editable)</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                Update
            </button>
        </div>
    </form>
</div>

<script>
    const select = document.getElementById('category_select');
    const customInput = document.getElementById('custom_category_input');
    const customCategory = document.getElementById('category');

    function toggleCustomInput() {
        if (select.value === '__other__') {
            customInput.style.display = 'block';
            customCategory.required = true;
        } else {
            customInput.style.display = 'none';
            customCategory.required = false;
            customCategory.value = select.value;
        }
    }

    select.addEventListener('change', toggleCustomInput);
    window.addEventListener('load', toggleCustomInput);
</script>
@endsection
