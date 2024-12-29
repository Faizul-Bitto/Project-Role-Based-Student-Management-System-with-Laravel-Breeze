<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome to Startsmartz Technologies</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white">
    <div class="bg-gray-50 text-black dark:bg-white dark:text-white bg-opacity-70">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <header class="py-10">
                <h1 class="text-4xl font-bold text-center  text-[#7f23c5]">Welcome to Startsmartz Technologies Student
                    Management Application</h1>
            </header>

            <div class="shrink-0 flex items-center">
                <img src={{ asset('logo/logo.jpeg') }} alt="Your Logo"
                    class="block h-20 w-auto mb-6 border-2 border-[#7f23c5] rounded-full" />
            </div>

            <div class="flex flex-col items-center gap-4">
                @if (Route::has('login'))
                    <nav class="flex flex-col items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-[#7f23c5] text-white rounded-md px-6 py-3 transition duration-300 hover:bg-[#c024c5]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-[#7f23c5] text-white rounded-md px-8 py-3 transition duration-300 hover:bg-[#c024c5]">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-[#7f23c5] text-white rounded-md px-6 py-3 transition duration-300 hover:bg-[#c024c5] mt-2">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>

            <footer class="py-16 text-center text-sm text-gray-900 dark:text-gray/70">
                <p>&copy; {{ date('Y') }} Startmartz Technologies - Student Management. All rights reserved.</p>
            </footer>
        </div>
    </div>
</body>

</html>
