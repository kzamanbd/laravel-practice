<?php

namespace DraftScripts\Messaging;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use RuntimeException;

class Messaging
{
    /**
     * Get the default JavaScript variables for Messaging.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('messaging.path'),
        ];
    }


    /**
     * Get the CSS for the Messaging dashboard.
     *
     * @return Illuminate\Contracts\Support\Htmlable
     */
    public static function css()
    {

        if (($app = @file_get_contents(__DIR__ . '/../dist/app.css')) === false) {
            throw new RuntimeException('Unable to load the Messaging dashboard CSS.');
        }

        return new HtmlString(<<<HTML
            <style>{$app}</style>
            HTML);
    }

    /**
     * Get the JS for the Messaging dashboard.
     *
     * @return \Illuminate\Contracts\Support\Htmlable
     */
    public static function js()
    {
        if (($js = @file_get_contents(__DIR__ . '/../dist/app.js')) === false) {
            throw new RuntimeException('Unable to load the Messaging dashboard JavaScript.');
        }

        $messaging = Js::from(static::scriptVariables());

        return new HtmlString(<<<HTML
            <script type="module">
                window.Messaging = {$messaging};
                {$js}
            </script>
            HTML);
    }
}
