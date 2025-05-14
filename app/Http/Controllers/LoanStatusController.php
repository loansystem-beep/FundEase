<?php

namespace App\Http\Controllers;

use App\Models\LoanStatus;
use Illuminate\Http\Request;

class LoanStatusController extends Controller
{
    public function index()
    {
        $statuses = LoanStatus::all()->groupBy('category');
        return view('loan_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('loan_statuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        LoanStatus::create($validated);

        return redirect()->route('loan-statuses.index')->with('success', 'Loan status created successfully.');
    }

    public function show(LoanStatus $loanStatus)
    {
        return view('loan_statuses.show', compact('loanStatus'));
    }

    public function edit(LoanStatus $loanStatus)
    {
        // Fetch unique category options for dropdown
        $categories = LoanStatus::distinct()->pluck('category');
        return view('loan_statuses.edit', compact('loanStatus', 'categories'));
    }

    public function update(Request $request, LoanStatus $loanStatus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $loanStatus->update($validated);

        return redirect()->route('loan-statuses.index')->with('success', 'Loan status updated successfully.');
    }

    public function destroy(LoanStatus $loanStatus)
    {
        if ($loanStatus->is_system_generated) {
            return redirect()->route('loan-statuses.index')->with('error', 'Cannot delete a system-generated status.');
        }

        $loanStatus->delete();

        return redirect()->route('loan-statuses.index')->with('success', 'Loan status deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'category' => 'required|string'
        ]);

        foreach ($request->order as $index => $id) {
            LoanStatus::where('id', $id)->where('category', $request->category)->update(['position' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
