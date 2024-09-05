<?php


return [

    /*
    |--------------------------------------------------------------------------
    | FileManager Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain which the FileManager dashboard will be accessible from.
    | When set to null, the dashboard will reside under the same domain as
    | the application. Remember to configure your DNS entries correctly.
    |
    */

    'domain' => env('FILE_MANAGER'),

    /*
    |--------------------------------------------------------------------------
    | FileManager Path
    |--------------------------------------------------------------------------
    |
    | This is the path which the FileManager dashboard will be accessible from. Feel
    | free to change this path to anything you'd like. Note that this won't
    | affect the path of the internal API that is never exposed to users.
    |
    */

    'path' => env('FILE_MANAGER', 'file-manager'),

    'middleware' => [
        'web',
        \DraftScripts\FileManager\Http\Middleware\Authorize::class,
        'auth:web'
    ],

];
