<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffRole;
use App\Models\Branch;
use App\Models\StaffEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Display a listing of the staff
    public function index()
    {
        $staff = Staff::with('roles', 'branches')->get();
        return view('staff.index', compact('staff'));
    }

    // Show the form for creating a new staff
    public function create()
    {
        // Fetch all roles and branches
        $roles = StaffRole::all();
        $branches = Branch::all();
        
        // Return the create view with the roles and branches data
        return view('staff.create', compact('roles', 'branches'));
    }

    // Store a newly created staff member
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:staff_roles,id',  // Validate that the role IDs exist in the staff_roles table
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id', // Validate that the branch IDs exist in the branches table
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create staff member
        $staff = Staff::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign roles to the staff
        $staff->roles()->sync($validated['role_ids']); // Sync roles using the role_ids

        // Assign branches to the staff
        $staff->branches()->sync($validated['branch_ids']); // Sync branches using the branch_ids

        // Create staff email notifications (with default preferences)
        StaffEmailNotification::create([
            'staff_id' => $staff->id,
            'notify_on_loan_disbursement' => false,
            'notify_on_loan_repayment' => false,
            'notify_on_savings_transaction' => false,
            'notify_on_expense' => false,
            'notify_on_income' => false,
            'notify_on_overdue' => false,
            'notify_on_upcoming_due' => false,
            'notify_on_guarantee_request' => false,
            'notify_on_collateral_activity' => false,
            'notify_on_account_activity' => false,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully');
    }

    // Show the form for editing a staff member
    public function edit(Staff $staff)
    {
        // Fetch all roles and branches
        $roles = StaffRole::all();
        $branches = Branch::all();
        
        // Return the edit view with the current staff, roles, and branches
        return view('staff.edit', compact('staff', 'roles', 'branches'));
    }

    // Update the staff member
    public function update(Request $request, Staff $staff)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:staff_roles,id',
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'exists:branches,id',
        ]);

        // Update staff member details
        $staff->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        // Update roles for the staff
        $staff->roles()->sync($validated['role_ids']); // Sync updated roles

        // Update branches for the staff
        $staff->branches()->sync($validated['branch_ids']); // Sync updated branches

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully');
    }

    // Delete the staff member
    public function destroy(Staff $staff)
    {
        // Delete the staff member
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully');
    }

    // Show a specific staff member
    public function show(Staff $staff)
    {
        // Return the show view for the staff member
        return view('staff.show', compact('staff'));
    }
}
