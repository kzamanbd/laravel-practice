<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    DraftScripts\BdLocation\BdLocationServiceProvider::class,
    DraftScripts\Permission\PermissionServiceProvider::class,
    DraftScripts\Messaging\MessagingServiceProvider::class,
    DraftScripts\FileManager\FileManagerServiceProvider::class,
];
