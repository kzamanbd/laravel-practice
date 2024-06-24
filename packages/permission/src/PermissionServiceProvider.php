<?php

namespace Draftscripts\Permission;

class PermissionServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }

    /**
     * Register any application services.
     */

    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }
}
