<?php

namespace DraftScripts\Permission\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static \DraftScripts\Permission\LaraPermission register(array $recorders)
 * @method static \DraftScripts\Permission\LaraPermission rememberUser(\Illuminate\Contracts\Auth\Authenticatable $user)
 * @method static \DraftScripts\Permission\LaraPermission|string css(string|\Illuminate\Contracts\Support\Htmlable|array|null $css = null)
 * @method static string js()
 * @method static array defaultVendorCacheKeys()
 * @method static bool registersRoutes()
 * @method static \DraftScripts\Permission\Models\User userModel()
 * @method static \DraftScripts\Permission\LaraPermission ignoreRoutes()
 * @method static \DraftScripts\Permission\LaraPermission handleExceptionsUsing(callable $callback)
 * @method static mixed rescue(callable $callback)
 * @method static \DraftScripts\Permission\LaraPermission setContainer(\Illuminate\Contracts\Foundation\Application $container)
 * @method static void afterResolving(\Illuminate\Contracts\Foundation\Application $app, string $class, \Closure $callback)
 * @see \DraftScripts\Permission\LaraPermission
 */
class LaraPermission extends Facade
{
    /**
     * Get the registered name of the component.
     */
    public static function getFacadeAccessor(): string
    {
        return \DraftScripts\Permission\LaraPermission::class;
    }
}
