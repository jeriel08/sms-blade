<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex flex-col items-center justify-center font-sans bg-cover bg-center bg-no-repeat text-gray-900 antialiased" style="background-image: url('{{ asset('images/background.png') }}')">
    <div class="w-full sm:max-w-md mt-6 shadow-md overflow-hidden sm:rounded-lg">
        <!-- Blue Header -->
        <div class="h-24 bg-blue-900 flex items-end justify-center rounded-t-xl">
            <!-- Logo container with negative margin to push it down -->
            <div class="-mb-8">
                <a href="/">
                    <x-application-logo class="w-28 h-28 fill-current rounded-full bg-white p-2" />
                </a>
            </div>
        </div>
        
        <!-- White Content Area -->
        <div class="bg-white px-6 py-8 pt-12 md:px-10"> <!-- Extra top padding to accommodate the logo -->
            {{ $slot }}
        </div>
    </div>
</body>
</html>
