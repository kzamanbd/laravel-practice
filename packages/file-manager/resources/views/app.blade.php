<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>File Manager - {{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}">

        <!-- Style -->
        {!! (new \DraftScripts\FileManager\FileManager())->css() !!}
        <!-- Scripts -->
        {!! (new \DraftScripts\FileManager\FileManager())->js() !!}
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Page Heading -->

            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('File Manager') }}
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main id="file-manager"></main>
        </div>
    </body>

</html>
