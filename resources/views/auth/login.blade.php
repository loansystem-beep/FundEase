<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FundEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Welcome Back</h2>
        <p class="text-sm text-center text-gray-500 mb-6">Sign in to your account</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="font-medium" />
                <x-text-input id="email" class="w-full mt-2 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="font-medium" />
                <x-text-input id="password" class="w-full mt-2 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-300" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex justify-between items-center mt-4">
                <label for="remember_me" class="flex items-center text-sm text-gray-600">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition-all">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">{{ __('Register here') }}</a>
            </p>
        </div>
    </div>
</body>
</html>
