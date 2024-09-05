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
        <div id="file-manager" class="min-h-screen bg-gray-100"></div>
    </body>

</html>
