<?php

namespace DraftScripts\Permission;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use RuntimeException;

class LaraPermission
{
    /**
     * Indicates if Permission routes will be registered.
     */
    protected bool $registersRoutes = true;

    public function registersRoutes(): bool
    {
        return $this->registersRoutes;
    }
    /**
     * Get the default JavaScript variables for Messaging.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('lara-permission.path'),
        ];
    }


    /**
     * Get the CSS for the Messaging dashboard.
     *
     * @return HtmlString
     */
    public static function css()
    {
        if (($app = @file_get_contents(__DIR__ . '/../dist/app.css')) === false) {
            throw new RuntimeException('Unable to load the Permission dashboard CSS.');
        }

        return new HtmlString(<<<HTML
            <style>{$app}</style>
            HTML);
    }

    /**
     * Get the JS for the Permission dashboard.
     *
     * @return HtmlString
     */
    public static function js()
    {
        if (
            ($livewire = @file_get_contents(__DIR__ . '/../../../vendor/livewire/livewire/dist/livewire.js')) === false
        ) {
            throw new RuntimeException('Unable to load the Livewire JavaScript.');
        }
        if (($appJs = @file_get_contents(__DIR__ . '/../dist/app.js')) === false) {
            throw new RuntimeException('Unable to load the Permission dashboard JavaScript.');
        }

        $permission = Js::from(static::scriptVariables());

        return new HtmlString(<<<HTML
            <script>
                window.livewire = {$livewire};
            </script>
            <script type="module">
                window.Permission = {$permission};
                {$appJs};
            </script>
            HTML);
    }

    public function userModel()
    {
        return config('lara-permission.models.user');
    }
}
