@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Savings Transaction</h1>

    <form action="{{ route('savings-transactions.update', $savingsTransaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Savings Account Selection -->
        <div class="mb-3">
            <label for="savings_account_id" class="form-label">Savings Account</label>
            <select name="savings_account_id" id="savings_account_id" class="form-control" required>
                <option value="">Select Savings Account</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" {{ $savingsTransaction->savings_account_id == $account->id ? 'selected' : '' }}>
                        {{ $account->account_number }} ({{ number_format($account->balance, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Borrower Search -->
        <div class="mb-3">
            <label for="borrower_search" class="form-label">Search Borrower</label>
            <input type="text" name="borrower_search" id="borrower_search" class="form-control"value="{{ $savingsTransaction->borrower->first_name }} {{ $savingsTransaction->borrower->last_name }}"
            onkeyup="searchBorrower()">
            <ul id="borrower_list" class="list-group mt-2" style="display:none;"></ul>
        </div>

        <!-- Borrower ID (Hidden) -->
        <input type="hidden" name="borrower_id" id="borrower_id" value="{{ $savingsTransaction->borrower_id }}">

        <!-- Action Field -->
        <div class="mb-3">
            <label for="action" class="form-label">Action</label>
            <input type="text" name="action" id="action" class="form-control" value="{{ $savingsTransaction->action }}" required>
        </div>

        <!-- Other Fields (same as before) -->
        <!-- Account Number, Ledger Balance, etc... -->

        <button type="submit" class="btn btn-warning">Update Transaction</button>
    </form>
</div>

<script>
    function searchBorrower() {
        var query = document.getElementById('borrower_search').value;

        if (query.length < 3) {
            document.getElementById('borrower_list').style.display = 'none';
            return;
        }

        fetch(`/search-borrower?query=${query}`)
            .then(response => response.json())
            .then(data => {
                var borrowerList = document.getElementById('borrower_list');
                borrowerList.innerHTML = '';
                if (data.length > 0) {
                    borrowerList.style.display = 'block';
                    data.forEach(borrower => {
                        var listItem = document.createElement('li');
                        listItem.classList.add('list-group-item');
                        listItem.textContent = borrower.first_name + ' ' + borrower.last_name;
                        listItem.setAttribute('data-id', borrower.id);
                        listItem.onclick = function () {
                            selectBorrower(borrower.id, borrower.first_name, borrower.last_name);
                        };
                        borrowerList.appendChild(listItem);
                    });
                } else {
                    borrowerList.style.display = 'none';
                }
            })
            .catch(error => console.error('Error fetching borrower data:', error));
    }

    function selectBorrower(id, first_name, last_name) {
        document.getElementById('borrower_id').value = id;
        document.getElementById('borrower_search').value = first_name + ' ' + last_name;
        document.getElementById('borrower_list').style.display = 'none';
    }
</script>

@endsection
