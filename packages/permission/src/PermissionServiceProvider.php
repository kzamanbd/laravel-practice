<?php

namespace Draftscripts\Permission;

use Draftscripts\Permission\Livewire\UserManagement;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory as ViewFactory;
use Livewire\LivewireManager;

class PermissionServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/lara-permission.php', 'lara-permission'
        );

        $this->app->singleton(LaraPermission::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerAuthorization();
        $this->registerRoutes();
        $this->registerResources();
        $this->registerComponents();
        $this->registerPublishing();

         // Load migrations from the specified path
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the package authorization.
     */
    protected function registerAuthorization(): void
    {
        $this->callAfterResolving(Gate::class, function (Gate $gate, Application $app) {
            $gate->define('viewPermission', fn ($user = null) => $app->environment('local'));
        });
    }

    protected function registerRoutes(): void
    {
        $this->callAfterResolving('router', function (Router $router, Application $app) {
            if ($app->make(LaraPermission::class)->registersRoutes()) {
                $router->group([
                    'domain' => $app->make('config')->get('lara-permission.domain', null),
                    'prefix' => $app->make('config')->get('lara-permission.path', 'permission'),
                    'middleware' => $app->make('config')->get('lara-permission.middleware'),
                ], function (Router $router) {
                     $router->get('/users', UserManagement::class)->name('lara-permission.users');
                });
            }
        });
    }

    protected function registerComponents(): void
    {
        $this->callAfterResolving('blade.compiler', function (BladeCompiler $blade) {
            $blade->anonymousComponentPath(__DIR__ . '/../resources/views/components', 'lara-permission');
        });

        $this->callAfterResolving('livewire', function (LivewireManager $livewire, Application $app) {
            $middleware = collect($app->make('config')->get('lara-permission.middleware')) // @phpstan-ignore argument.templateType, argument.templateType
            ->map(fn($middleware) => is_string($middleware)
                ? Str::before($middleware, ':')
                : $middleware)
                ->all();

            $livewire->addPersistentMiddleware($middleware);
            $livewire->component('lara-permission.navigation', Livewire\Navigation::class);
            $livewire->component('lara-permission.users', Livewire\UserManagement::class);
        });
    }

    /**
     * Register the package's resources.
     */
    protected function registerResources(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lara-permission');
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/lara-permission.php' => config_path('lara-permission.php'),
            ], ['lara-permission', 'lara-permission-config']);

            $method = method_exists($this, 'publishesMigrations') ? 'publishesMigrations' : 'publishes';

            $this->{$method}([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], ['lara-permission', 'lara-permission-migrations']);
        }
    }
}
