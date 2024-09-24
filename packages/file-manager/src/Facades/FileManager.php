<?php

namespace DraftScripts\FileManager\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static HtmlString css()
 * @method static HtmlString js()
 * @method static bool registersRoutes()
 * @method static array scriptVariables()
 * @method static array getDiskList()
 * @method static bool checkDisk($name)
 * @method static bool checkPath($disk, $path)
 * @method static array getFileInfo(SplFileInfo $item, $pathReplace = null)
 * @method static string formatSizeUnits($bytes)
 * @method static array getContent($disk, $path = null)
 * @method static array directoriesWithProperties($disk, $path = null)
 * @method static array filesWithProperties($disk, $path = null)
 * @method static array getDirectoriesTree($disk, $path = null)
 * @method static array fileProperties($disk, $path = null)
 * @method static array directoryProperties($disk, $path = null)
 *
 *
 *
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
