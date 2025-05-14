<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // Display a listing of the permissions
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    // Show the form for creating a new permission
    public function create()
    {
        return view('permissions.create');
    }

    // Store a newly created permission in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
        ]);

        Permission::create($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    // Display the specified permission
    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    // Show the form for editing the specified permission
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    // Update the specified permission in storage
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
        ]);

        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    // Remove the specified permission from storage
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
