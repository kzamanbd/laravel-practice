<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Permission Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain which the Permission dashboard will be accessible from.
    | When set to null, the dashboard will reside under the same domain as
    | the application. Remember to configure your DNS entries correctly.
    |
    */

    'domain' => env('LARA_PERMISSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Permission Path
    |--------------------------------------------------------------------------
    |
    | This is the path which the Permission dashboard will be accessible from. Feel
    | free to change this path to anything you'd like. Note that this won't
    | affect the path of the internal API that is never exposed to users.
    |
    */

    'path' => env('LARA_PERMISSION_PATH', 'permission'),

    /*
    |--------------------------------------------------------------------------
    | Permission Storage Driver
    |--------------------------------------------------------------------------
    |
    | This configuration option determines which storage driver will be used
    | while storing entries from Permission's recorders. In addition, you also
    | may provide any options to configure the selected storage driver.
    |
    */

    'storage' => [
        'driver' => env('LARA_PERMISSION_STORAGE_DRIVER', 'database'),

        'database' => [
            'connection' => env('LARA_PERMISSION_DB_CONNECTION', null),
            'chunk' => 1000,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Permission Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every Permission route, giving you the
    | chance to add your own middleware to this list or change any of the
    | existing middleware. Of course, reasonable defaults are provided.
    |
    */

    'middleware' => [
        'web',
        \DraftScripts\Permission\Http\Middleware\Authorize::class,
        'auth:web'
    ],
    'model' => \DraftScripts\Permission\Models\User::class
];
