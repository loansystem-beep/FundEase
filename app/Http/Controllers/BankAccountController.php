<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the bank accounts.
     */
    public function index(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('search', '');
        $statusFilter = $request->input('status', ''); // Get the status filter (active/inactive)

        // Retrieve paginated bank accounts with search and status filter applied (server-side)
        $bankAccounts = BankAccount::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'like', '%' . $query . '%')
                         ->orWhere('account_number', 'like', '%' . $query . '%')
                         ->orWhere('bank_name', 'like', '%' . $query . '%')
                         ->orWhere('currency', 'like', '%' . $query . '%');
        })
        ->when($statusFilter, function ($queryBuilder) use ($statusFilter) {
            if ($statusFilter === 'active') {
                $queryBuilder->where('is_active', true); // Only show active accounts
            } elseif ($statusFilter === 'inactive') {
                $queryBuilder->where('is_active', false); // Only show inactive accounts
            }
        })
        ->latest()
        ->paginate(20); // Adjust per-page limit as needed

        // Return the view with paginated bank accounts, search query, and status filter
        return view('bank_accounts.index', compact('bankAccounts', 'query', 'statusFilter'));
    }

    /**
     * Show the form for creating a new bank account.
     */
    public function create()
    {
        $banks = $this->getBanks();
        $swiftCodes = $this->getSwiftCodes();
        $branches = $this->getBranches();

        return view('bank_accounts.create', compact('banks', 'swiftCodes', 'branches'));
    }

    /**
     * Store a newly created bank account in storage.
     */
    public function store(Request $request)
    {
        // Validate the request input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:255',
            'branch' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        // Check if the account number already exists
        $existingAccount = BankAccount::where('account_number', $validated['account_number'])->first();

        if ($existingAccount) {
            // If the account already exists, redirect with an error message
            return redirect()->route('bank_accounts.index')->with('error', 'This bank account already exists.');
        }

        // Proceed to create the bank account if it does not exist
        $validated['is_active'] = $request->has('is_active'); // Set is_active based on the checkbox
        BankAccount::create($validated);

        // Redirect to the index page with a success message
        return redirect()->route('bank_accounts.index')->with('success', 'Bank account created successfully.');
    }

    /**
     * Display the specified bank account.
     */
    public function show(BankAccount $bankAccount)
    {
        return view('bank_accounts.show', compact('bankAccount'));
    }

    /**
     * Show the form for editing the specified bank account.
     */
    public function edit(BankAccount $bankAccount)
    {
        $banks = $this->getBanks();
        $swiftCodes = $this->getSwiftCodes();
        $branches = $this->getBranches();

        return view('bank_accounts.edit', compact('bankAccount', 'banks', 'swiftCodes', 'branches'));
    }

    /**
     * Update the specified bank account in storage.
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:255',
            'branch' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:200',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $bankAccount->update($validated);

        return redirect()->route('bank_accounts.index')->with('success', 'Bank account updated successfully.');
    }

    /**
     * Remove the specified bank account from storage.
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()->route('bank_accounts.index')->with('success', 'Bank account deleted successfully.');
    }

    /**
     * Get list of banks for selection.
     */
    private function getBanks()
    {
        return [
            'Kenya Commercial Bank',
            'Equity Bank',
            'Co-operative Bank',
            'Absa Bank Kenya',
            'Stanbic Bank Kenya',
            'National Bank of Kenya',
            'Family Bank',
            'I&M Bank Kenya',
            // Add more banks as needed
        ];
    }

    /**
     * Get list of SWIFT codes for selection.
     */
    private function getSwiftCodes()
    {
        return [
            'KENYKENX - Kenya Commercial Bank',
            'EQBLKENA - Equity Bank Kenya',
            // Add more SWIFT codes as needed
        ];
    }

    /**
     * Get list of branches for selection.
     */
    private function getBranches()
    {
        return [
            'Kenya Commercial Bank - Nairobi',
            'Equity Bank - Nairobi',
            // Add more branches as needed
        ];
    }
}
