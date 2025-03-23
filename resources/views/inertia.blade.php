<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @if (request()->routeIs('files*'))
            @vite(['resources/js/file-manager.tsx'])
        @elseif(request()->routeIs('messaging*'))
            @vite(['resources/js/messaging.ts'])
        @endif
        @inertiaHead
    </head>

    <body class="min-h-screen bg-gray-100">
        @inertia
    </body>

</html>
