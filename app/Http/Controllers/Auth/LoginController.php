<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override attemptLogin to handle inactive users.
     */
    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return false; // wrong credentials
        }

        // If user is inactive, redirect them to payment page
        if ($user->status !== 'active' || !$user->is_active) {
            session(['inactive_user_id' => $user->id]);
            redirect()->route('payments.form')->send(); // route to payment form
        }

        return Auth::login($user, $request->filled('remember'));
    }

    /**
     * Credentials used in default attemptLogin (still required).
     */
    protected function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
        ];
    }
}
