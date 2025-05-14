<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role; // Import the Role model to assign roles
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate user input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active', // Optional: Include if needed in your system
        ]);

        // Assign the "User" role to the newly registered user
        $userRole = Role::where('name', 'User')->first(); // Get the "User" role
        if ($userRole) {
            $user->roles()->attach($userRole); // Attach the role to the user
        }

        // Trigger the Registered event and log the user in
        event(new Registered($user));
        Auth::login($user); // Automatically log the user in

        // Redirect to the dashboard or any other page
        return redirect()->route('dashboard'); // Change this as needed
    }
}
