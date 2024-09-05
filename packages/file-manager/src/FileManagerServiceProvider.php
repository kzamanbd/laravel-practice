<?php

namespace DraftScripts\FileManager;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/file-manager.php',
            'file-manager'
        );

        $this->app->singleton(FileManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerAuthorization();
        $this->registerRoutes();
        $this->registerResources();
        $this->registerPublishing();

        // Load migrations from the specified path
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register the package authorization.
     */
    protected function registerAuthorization(): void
    {
        $this->callAfterResolving(Gate::class, function (Gate $gate, Application $app) {
            $gate->define('viewFileManager', function () {
                return Auth::check();
            });
        });
    }

    protected function registerRoutes(): void
    {
        if ($this->app instanceof CachesRoutes && $this->app->routesAreCached()) {
            return;
        }
        Route::group([
            'domain' => config('file-manager.domain', null),
            'prefix' => config('file-manager.path'),
            'middleware' => config('file-manager.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    /**
     * Register the package's resources.
     */
    protected function registerResources(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'file-manager');
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/file-manager.php' => config_path('file-manager.php')
            ], ['file-manager', 'file-manager-config']);

            $method = method_exists($this, 'publishesMigrations') ? 'publishesMigrations' : 'publishes';

            $this->{$method}([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], ['file-manager', 'file-manager-migrations']);
        }
    }
}
