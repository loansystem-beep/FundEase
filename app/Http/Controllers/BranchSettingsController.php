<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchSettingsController extends Controller
{
    // Show the branch settings form
    public function edit(Branch $branch)
    {
        return view('branches.settings', compact('branch'));
    }

    // Update the branch settings
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'min_loan_amount' => 'nullable|numeric|min:0',
            'max_loan_amount' => 'nullable|numeric|min:0',
            'min_interest_rate' => 'nullable|numeric|min:0',
            'max_interest_rate' => 'nullable|numeric|min:0',
            'holidays' => 'nullable|array',
            'holidays.*' => 'date',
        ]);

        $branch->update([
            'min_loan_amount' => $request->min_loan_amount,
            'max_loan_amount' => $request->max_loan_amount,
            'min_interest_rate' => $request->min_interest_rate,
            'max_interest_rate' => $request->max_interest_rate,
            'holidays' => $request->holidays,
        ]);

        return redirect()->route('branches.settings.edit', $branch)->with('success', 'Branch settings updated successfully.');
    }
}
