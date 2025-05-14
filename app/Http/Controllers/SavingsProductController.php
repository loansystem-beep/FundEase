<?php

namespace App\Http\Controllers;

use App\Models\SavingsProduct;
use Illuminate\Http\Request;

class SavingsProductController extends Controller
{
    // Show the list of savings products
    public function index()
    {
        $products = SavingsProduct::all();
        return view('savings.products.index', compact('products'));
    }

    // Show the form to create a new savings product
    public function create()
    {
        return view('savings.products.create');
    }

    // Store a new savings product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric',
            'interest_type' => 'required|string',
            'allow_withdrawals' => 'required|boolean',
        ]);

        SavingsProduct::create($validated);

        return redirect()->route('savings.products.index')->with('success', 'Savings Product created successfully.');
    }

    // Show the form to edit an existing savings product
    public function edit(SavingsProduct $savingsProduct)
    {
        return view('savings.products.edit', compact('savingsProduct'));
    }

    // Update an existing savings product
    public function update(Request $request, SavingsProduct $savingsProduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric',
            'interest_type' => 'required|string',
            'allow_withdrawals' => 'required|boolean',
        ]);

        $savingsProduct->update($validated);

        return redirect()->route('savings.products.index')->with('success', 'Savings Product updated successfully.');
    }

    // Delete an existing savings product
    public function destroy(SavingsProduct $savingsProduct)
    {
        $savingsProduct->delete();

        return redirect()->route('savings.products.index')->with('success', 'Savings Product deleted successfully.');
    }
}
