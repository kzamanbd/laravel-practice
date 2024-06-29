<?php

namespace DraftScripts\BdLocation;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class BdLocationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        // Load routes, migrations, etc.
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [Console\InstallCommand::class];
    }
}
