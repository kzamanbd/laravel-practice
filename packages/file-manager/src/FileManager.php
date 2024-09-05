<?php

namespace DraftScripts\FileManager;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use RuntimeException;

class FileManager
{
    /**
     * Get the default JavaScript variables for FileManager.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('file-manager.path'),
        ];
    }


    /**
     * Get the CSS for the FileManager dashboard.
     *
     * @return HtmlString
     */
    public static function css()
    {

        if (($app = @file_get_contents(__DIR__ . '/../dist/app.css')) === false) {
            throw new RuntimeException('Unable to load the FileManager dashboard CSS.');
        }

        return new HtmlString(<<<HTML
            <style>{$app}</style>
            HTML);
    }

    /**
     * Get the JS for the FileManager dashboard.
     *
     * @return HtmlString
     */
    public static function js()
    {
        if (($appJs = @file_get_contents(__DIR__ . '/../dist/main.js')) === false) {
            throw new RuntimeException('Unable to load the FileManager dashboard JavaScript.');
        }

        $files = Js::from(static::scriptVariables());

        return new HtmlString(<<<HTML
            <script type="module">
                window.FileManager = {$files};
                {$appJs};
            </script>
            HTML);
    }
}
