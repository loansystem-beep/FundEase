<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRule;
use Illuminate\Http\Request;

class ApprovalRuleController extends Controller
{
    /**
     * Display a listing of the approval rules.
     */
    public function index()
    {
        $approvalRules = ApprovalRule::all(); // Fetch all approval rules from the database
        return view('approval_rules.index', compact('approvalRules')); // Return a view with the rules
    }

    /**
     * Show the form for creating a new approval rule.
     */
    public function create()
    {
        return view('approval_rules.create'); // Return the view to create a new rule
    }

    /**
     * Store a newly created approval rule in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'rule_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'min_value' => 'required|numeric',
            'max_value' => 'required|numeric|gte:min_value',
            'role_name' => 'required|string|max:255',
        ]);

        // Create the approval rule
        ApprovalRule::create($validated);

        // Redirect with success message
        return redirect()->route('approval_rules.index')->with('success', 'Approval rule created successfully.');
    }

    /**
     * Display the specified approval rule.
     */
    public function show(ApprovalRule $approvalRule)
    {
        return view('approval_rules.show', compact('approvalRule')); // Show the specific approval rule details
    }

    /**
     * Show the form for editing the specified approval rule.
     */
    public function edit(ApprovalRule $approvalRule)
    {
        return view('approval_rules.edit', compact('approvalRule')); // Show the form to edit the rule
    }

    /**
     * Update the specified approval rule in storage.
     */
    public function update(Request $request, ApprovalRule $approvalRule)
    {
        // Validate input
        $validated = $request->validate([
            'rule_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'min_value' => 'required|numeric',
            'max_value' => 'required|numeric|gte:min_value',
            'role_name' => 'required|string|max:255',
        ]);

        // Update the approval rule
        $approvalRule->update($validated);

        // Redirect with success message
        return redirect()->route('approval_rules.index')->with('success', 'Approval rule updated successfully.');
    }

    /**
     * Remove the specified approval rule from storage.
     */
    public function destroy(ApprovalRule $approvalRule)
    {
        // Delete the approval rule
        $approvalRule->delete();

        // Redirect with success message
        return redirect()->route('approval_rules.index')->with('success', 'Approval rule deleted successfully.');
    }
}
