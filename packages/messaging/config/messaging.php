<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Messaging Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain which the Messaging dashboard will be accessible from.
    | When set to null, the dashboard will reside under the same domain as
    | the application. Remember to configure your DNS entries correctly.
    |
    */

    'domain' => env('MESSAGING_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Messaging Path
    |--------------------------------------------------------------------------
    |
    | This is the path which the Messaging dashboard will be accessible from. Feel
    | free to change this path to anything you'd like. Note that this won't
    | affect the path of the internal API that is never exposed to users.
    |
    */

    'path' => env('MESSAGING_PATH', 'messaging'),

    'reverb' =>  env('MESSAGING_REVERB', null),

    'middleware' => [
        'web',
        \DraftScripts\Messaging\Http\Middleware\Authorize::class,
        'auth:web'
    ],

];
