<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? null }} - {{ config('app.name', 'Laravel') }}</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/material-icons.css') }}" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    {{ $head ?? null }}

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <!-- Scripts -->
    @livewireScripts
    <x-progress-bar />
    <x-confirmation-alert />
    <x-progress-dialog />
    {{ $scripts ?? null }}
</body>

</html>
