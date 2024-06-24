<?php

namespace Draftscripts\Permission\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static \Draftscripts\Permission\LaraPermission register(array $recorders)
 * @method static \Draftscripts\Permission\LaraPermission rememberUser(\Illuminate\Contracts\Auth\Authenticatable $user)
 * @method static \Draftscripts\Permission\LaraPermission|string css(string|\Illuminate\Contracts\Support\Htmlable|array|null $css = null)
 * @method static string js()
 * @method static array defaultVendorCacheKeys()
 * @method static bool registersRoutes()
 * @method static \Draftscripts\Permission\Models\User userModel()
 * @method static \Draftscripts\Permission\LaraPermission ignoreRoutes()
 * @method static \Draftscripts\Permission\LaraPermission handleExceptionsUsing(callable $callback)
 * @method static mixed rescue(callable $callback)
 * @method static \Draftscripts\Permission\LaraPermission setContainer(\Illuminate\Contracts\Foundation\Application $container)
 * @method static void afterResolving(\Illuminate\Contracts\Foundation\Application $app, string $class, \Closure $callback)
 * @see \Draftscripts\Permission\LaraPermission
 */
class LaraPermission extends Facade
{
/**
     * Get the registered name of the component.
     */
    public static function getFacadeAccessor(): string
    {
        return \Draftscripts\Permission\LaraPermission::class;
    }
}
