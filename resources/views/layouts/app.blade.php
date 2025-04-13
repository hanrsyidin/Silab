
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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900"
        style="background-image: url('/Background.png'); background-size: cover; background-position: center;">
            @include('layouts.navigation') 
            <div x-data="{ openSidebar: false, showButton: true }" 
            x-init="window.addEventListener('scroll', () => { if (window.scrollY > 50) { showButton = false } else { showButton = true } })">
            <!-- Tombol Buka Sidebar -->
            <button 
                class="fixed top-4 left-4 z-50" 
                @click="openSidebar = true"
                x-show="!openSidebar"
                x-transition
            >
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </button>

            <!-- Sidebar -->
            <div 
                class="fixed top-0 left-0 w-64 h-full bg-gray-800 text-white p-6 shadow-lg z-40 transform transition-transform duration-300"
                :class="{ '-translate-x-full': !openSidebar, 'translate-x-0': openSidebar }">
                <ul class="space-y-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </ul>
            </div>

            <!-- Overlay -->
            <div 
                class="fixed inset-0 bg-black bg-opacity-50 z-30" 
                x-show="openSidebar"
                x-transition
                @click="openSidebar = false"
            ></div>
        </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
