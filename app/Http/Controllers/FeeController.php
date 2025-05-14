<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('search', ''); // Default to empty string if no search query is provided

        // Filter fees based on the search query
        $fees = Fee::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', '%' . $query . '%')
                ->orWhere('category', 'like', '%' . $query . '%')
                ->orWhere('calculation_method', 'like', '%' . $query . '%')
                ->orWhere('accounting_method', 'like', '%' . $query . '%');
        })->paginate(10); // Add pagination for better performance with large datasets

        // Return the view with the fees and search query
        return view('fees.index', compact('fees', 'query'));
    }

    public function create()
    {
        return view('fees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:deductible,non_deductible,capitalized',
            'calculation_method' => 'required|in:fixed,percentage',
            'calculation_base' => 'required|in:principal,interest,both',
            'default_amount' => 'required|numeric|min:0',
            'percentage_value' => 'nullable|numeric|min:0|max:100', // Validate percentage value
            'accounting_method' => 'required|in:accrual,cash',
            'accounting_type' => 'required|in:revenue,payable',
            'accrual_journal_entry' => 'nullable|string', // Validate accrual journal entry
            'cash_journal_entry' => 'nullable|string',    // Validate cash journal entry
            'description' => 'nullable|string',
        ]);

        Fee::create($validated);

        return redirect()->route('fees.index')->with('success', 'Fee created successfully.');
    }

    public function show(Fee $fee)
    {
        return view('fees.show', compact('fee'));
    }

    public function edit(Fee $fee)
    {
        return view('fees.edit', compact('fee'));
    }

    public function update(Request $request, Fee $fee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:deductible,non_deductible,capitalized',
            'calculation_method' => 'required|in:fixed,percentage',
            'calculation_base' => 'required|in:principal,interest,both',
            'default_amount' => 'required|numeric|min:0',
            'percentage_value' => 'nullable|numeric|min:0|max:100', // Validate percentage value
            'accounting_method' => 'required|in:accrual,cash',
            'accounting_type' => 'required|in:revenue,payable',
            'accrual_journal_entry' => 'nullable|string', // Validate accrual journal entry
            'cash_journal_entry' => 'nullable|string',    // Validate cash journal entry
            'description' => 'nullable|string',
        ]);

        $fee->update($validated);

        return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();

        return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
    }
}
