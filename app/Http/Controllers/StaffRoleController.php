<?php

namespace App\Http\Controllers;

use App\Models\StaffRole;
use Illuminate\Http\Request;

class StaffRoleController extends Controller
{
    // List all staff roles
    public function index()
    {
        $roles = StaffRole::all();
        return view('staff-roles.index', compact('roles'));
    }

    // Show form to create a new role
    public function create()
    {
        return view('staff-roles.create');
    }

    // Store new role
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:staff_roles,name',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'nullable|array',
        ]);

        StaffRole::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'permissions' => $validated['permissions'] ?? [],
        ]);

        return redirect()->route('admin.staff-roles.index')->with('success', 'Role created successfully.');
    }

    // Show form to edit a role
    public function edit(StaffRole $staff_role)
    {
        return view('staff-roles.edit', compact('staff-role'));
    }

    // Update a role
    public function update(Request $request, StaffRole $staff_role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:staff_roles,name,' . $staff_role->id,
            'description' => 'nullable|string|max:1000',
            'permissions' => 'nullable|array',
        ]);

        $staff_role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'permissions' => $validated['permissions'] ?? [],
        ]);

        return redirect()->route('admin.staff-roles.index')->with('success', 'Role updated successfully.');
    }

    // Delete a role
    public function destroy(StaffRole $staff_role)
    {
        $staff_role->delete();

        return redirect()->route('admin.staff-roles.index')->with('success', 'Role deleted successfully.');
    }
}
