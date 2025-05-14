<?php

namespace App\Http\Controllers;

use App\Models\LoginRestriction;
use Illuminate\Http\Request;

class LoginRestrictionController extends Controller
{
    /**
     * Display a listing of the login restrictions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all login restrictions
        $restrictions = LoginRestriction::all();

        // Return the view and pass the restrictions to it
        return view('login_restrictions.index', compact('restrictions'));
    }

    /**
     * Show the form for creating a new login restriction.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view
        return view('login_restrictions.create');
    }

    /**
     * Store a newly created login restriction in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'ip_address' => 'nullable|ip',
            'device' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_allowed' => 'required|boolean',
        ]);

        // Create a new login restriction in the database
        LoginRestriction::create($validated);

        // Redirect back to the index with a success message
        return redirect()->route('login.restrictions.index')->with('success', 'Restriction added successfully.');
    }

    /**
     * Show the form for editing the specified login restriction.
     *
     * @param  \App\Models\LoginRestriction  $loginRestriction
     * @return \Illuminate\Http\Response
     */
    public function edit(LoginRestriction $loginRestriction)
    {
        // Return the edit view and pass the restriction data
        return view('login_restrictions.edit', compact('loginRestriction'));
    }

    /**
     * Update the specified login restriction in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoginRestriction  $loginRestriction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoginRestriction $loginRestriction)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'ip_address' => 'nullable|ip',
            'device' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_allowed' => 'required|boolean',
        ]);

        // Update the login restriction in the database
        $loginRestriction->update($validated);

        // Redirect back to the index with a success message
        return redirect()->route('login.restrictions.index')->with('success', 'Restriction updated successfully.');
    }

    /**
     * Remove the specified login restriction from the database.
     *
     * @param  \App\Models\LoginRestriction  $loginRestriction
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoginRestriction $loginRestriction)
    {
        // Delete the specified login restriction
        $loginRestriction->delete();

        // Redirect back to the index with a success message
        return redirect()->route('login.restrictions.index')->with('success', 'Restriction deleted successfully.');
    }
}
