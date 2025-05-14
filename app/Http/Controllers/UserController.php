<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Constructor to apply authentication middleware if necessary
    public function __construct()
    {
        $this->middleware('auth');  // Optional: You can add role-based access middleware later
    }

    // Show the list of users
    public function index()
    {
        // Fetch users along with their roles
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    // Show form for creating a new user
    public function create()
    {
        // Get all available roles
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Store a new user
    public function store(Request $request)
    {
        // Validate user input
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,name',  // Ensure the role exists
        ]);

        // Create the new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Assign the selected role to the user
        $user->assignRole($validated['role']); // Use Spatie's assignRole method

        return redirect()->route('users.index');
    }

    // Show user details and assign a role
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();  // Get all available roles
        return view('users.show', compact('user', 'roles'));
    }

    // Assign a new role to a user
    public function assignRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',  // Validate role by name
        ]);

        $user = User::findOrFail($id);
        // Sync the new role (this will replace existing roles)
        $user->syncRoles([$validated['role']]); // Sync to ensure only one role is assigned at a time

        return redirect()->route('users.show', $user->id);
    }

    // Activate/Deactivate a user
    public function toggleActivation($id)
    {
        $user = User::findOrFail($id);
        // Toggle the user's activation status
        $user->is_active = !$user->is_active;
        $user->save();

        return back();  // Go back to the previous page
    }
}
