<?php

namespace DraftScripts\Messaging\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static \DraftScripts\Messaging\Messaging|string css(string|\Illuminate\Contracts\Support\Htmlable|array|null $css = null)
 * @method static string js()
 * @method static bool registersRoutes()
 * @see \DraftScripts\Messaging\Messaging
 */
class Messaging extends Facade
{
    /**
     * Get the registered name of the component.
     */
    public static function getFacadeAccessor(): string
    {
        return \DraftScripts\Messaging\Messaging::class;
    }
}
