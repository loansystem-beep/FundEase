<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Staff;
use App\Models\BranchStaff;
use Illuminate\Http\Request;

class BranchStaffController extends Controller
{
    // Show all staff-branch assignments
    public function index()
    {
        $assignments = BranchStaff::with(['staff', 'branch'])->get(); // Eager load staff and branch
        return view('branch-staff.index', compact('assignments'));
    }

    // Show the form to assign staff to a branch
    public function create($branchId)
    {
        $branch = Branch::findOrFail($branchId);
        $staff = Staff::all(); // List of all staff members
        return view('branch-staff.create', compact('branch', 'staff'));
    }

    // Store multiple staff-branch assignments
    public function store(Request $request, $branchId)
    {
        $validated = $request->validate([
            'staff_ids' => 'required|array',
            'staff_ids.*' => 'exists:staff,id',
        ]);

        $branch = Branch::findOrFail($branchId);
        $alreadyAssigned = [];

        foreach ($validated['staff_ids'] as $staffId) {
            $exists = BranchStaff::where('staff_id', $staffId)
                                 ->where('branch_id', $branchId)
                                 ->exists();

            if ($exists) {
                $alreadyAssigned[] = $staffId;
                continue;
            }

            BranchStaff::create([
                'staff_id' => $staffId,
                'branch_id' => $branchId,
            ]);
        }

        if (count($alreadyAssigned)) {
            return redirect()->route('branch.staff.create', $branchId)
                             ->with('error', 'Some staff were already assigned. Others were assigned successfully.');
        }

        return redirect()->route('branch.staff.create', $branchId)
                         ->with('success', 'Staff assigned to the branch successfully.');
    }

    // Remove a staff member from a branch
    public function destroy($branchId, $staffId)
    {
        $branch = Branch::findOrFail($branchId);
        $staff = Staff::findOrFail($staffId);

        $assignment = BranchStaff::where('branch_id', $branchId)
                                 ->where('staff_id', $staffId)
                                 ->first();

        if ($assignment) {
            $assignment->delete();
            return redirect()->route('branch.staff.index')
                             ->with('success', 'Staff removed from the branch successfully.');
        }

        return redirect()->route('branch.staff.index')
                         ->with('error', 'This staff is not assigned to the branch.');
    }
}
