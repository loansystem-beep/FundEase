<!-- resources/views/components/app-layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-md p-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-lg font-semibold">MyApp</a>
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-blue-500">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 ml-4">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-500">Login</a>
                        <a href="{{ route('register') }}" class="text-blue-500 ml-4">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 container mx-auto p-4">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-md p-4 text-center">
            &copy; {{ date('Y') }} MyApp. All rights reserved.
        </footer>
    </div>
</body>
</html>
