<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    DraftScripts\BdLocation\BdLocationServiceProvider::class,
    DraftScripts\FileManager\FileManagerServiceProvider::class,
    DraftScripts\Messaging\MessagingServiceProvider::class,
    DraftScripts\Permission\PermissionServiceProvider::class,
];