<?php

namespace DraftScripts\FileManager\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static HtmlString css()
 * @method static HtmlString js()
 * @method static bool registersRoutes()
 * @see \DraftScripts\FileManager\FileManager
 */
class FileManager extends Facade
{
    /**
     * Get the registered name of the component.
     */
    public static function getFacadeAccessor(): string
    {
        return \DraftScripts\FileManager\FileManager::class;
    }
}
