<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    // List of countries and their respective currencies
    private $countries_and_currencies = [
        'Kenya' => 'KES',
        'Uganda' => 'UGX',
        'Tanzania' => 'TZS',
        'Nigeria' => 'NGN',
        'South Africa' => 'ZAR',
        'United States' => 'USD',
        'United Kingdom' => 'GBP',
        // Add other countries and their currencies as needed
    ];

    // Display a listing of the branches
    public function index()
    {
        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    // Show the form for creating a new branch
    public function create()
    {
        return view('branches.create', ['countries_and_currencies' => $this->countries_and_currencies]);
    }

    // Store a newly created branch in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:branches,code',
            'location' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'date_format' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
        ]);

        Branch::create($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    // Show the form for editing the specified branch
    public function edit(Branch $branch)
    {
        return view('branches.edit', [
            'branch' => $branch,
            'countries_and_currencies' => $this->countries_and_currencies
        ]);
    }

    // Update the specified branch in storage
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:branches,code,' . $branch->id,
            'location' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'date_format' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
        ]);

        $branch->update($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    // Remove the specified branch from storage
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }

    // Show the specified branch (optional)
    public function show(Branch $branch)
    {
        return view('branches.show', compact('branch'));
    }
}
