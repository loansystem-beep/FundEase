<?php

namespace App\Http\Controllers;

use App\Models\BorrowerGroup;
use App\Models\Borrower;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowerGroupController extends Controller
{
    /**
     * Display a listing of the borrower groups.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $groups = BorrowerGroup::with('borrowers')->paginate(10);
        return view('borrowers.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new borrower group.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $borrowers = Borrower::all(); // Get all borrowers
        $loanOfficers = User::whereHas('roles', fn ($q) => $q->where('name', 'loan_officer'))->get();
        return view('borrowers.groups.create', compact('borrowers', 'loanOfficers'));
    }

    /**
     * Store a newly created borrower group in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'borrower_ids' => 'required|array|max:200',
            'borrower_ids.*' => 'exists:borrowers,id',
            'group_leader_id' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && !in_array($value, $request->borrower_ids ?? [])) {
                        $fail('Group leader must be one of the selected borrowers.');
                    }
                }
            ],
            'loan_officer_id' => 'nullable|exists:users,id',
            'collector_name' => 'nullable|string|max:255',
            'meeting_schedule' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Create the group
        $group = BorrowerGroup::create($validated);
        
        // Attach borrowers to the group
        $group->borrowers()->attach($validated['borrower_ids']);

        return redirect()->route('borrower-groups.index')->with('success', 'Borrower group created successfully.');
    }

    /**
     * Show the form for editing the specified borrower group.
     *
     * @param \App\Models\BorrowerGroup $borrowerGroup
     * @return \Illuminate\View\View
     */
    public function edit(BorrowerGroup $borrowerGroup)
    {
        $borrowers = Borrower::all(); // Get all borrowers
        $loanOfficers = User::whereHas('roles', fn ($q) => $q->where('name', 'loan_officer'))->get();
        return view('borrowers.groups.edit', compact('borrowers', 'loanOfficers', 'borrowerGroup'));
    }

    /**
     * Update the specified borrower group in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BorrowerGroup $borrowerGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BorrowerGroup $borrowerGroup)
    {
        // Validate incoming request
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'borrower_ids' => 'required|array|max:200',
            'borrower_ids.*' => 'exists:borrowers,id',
            'group_leader_id' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && !in_array($value, $request->borrower_ids ?? [])) {
                        $fail('Group leader must be one of the selected borrowers.');
                    }
                }
            ],
            'loan_officer_id' => 'nullable|exists:users,id',
            'collector_name' => 'nullable|string|max:255',
            'meeting_schedule' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Update the group
        $borrowerGroup->update($validated);

        // Sync borrowers with the group
        $borrowerGroup->borrowers()->sync($validated['borrower_ids']);

        return redirect()->route('borrower-groups.index')->with('success', 'Borrower group updated successfully.');
    }

    /**
     * Remove the specified borrower group from the database.
     *
     * @param \App\Models\BorrowerGroup $borrowerGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BorrowerGroup $borrowerGroup)
    {
        // Delete the borrower group and associated relationships
        $borrowerGroup->borrowers()->detach(); // Detach borrowers before deleting group
        $borrowerGroup->delete();

        return redirect()->route('borrower-groups.index')->with('success', 'Borrower group deleted successfully.');
    }
}
