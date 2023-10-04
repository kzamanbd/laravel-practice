<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{ $title ?? 'Report' }}</title>
        <style>
            table {
                width: 100%;
                color: black;
                border-collapse: collapse;
                font-family: Calibri;
                page-break-inside: auto;
            }
        </style>
        @if (isset($styles))
            {{ $styles }}
        @endif
    </head>

    <body>
        {{ $slot }}
    </body>

</html>
