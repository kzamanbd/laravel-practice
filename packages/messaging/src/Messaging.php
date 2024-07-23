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
     * Get Is Websocket config
     * @return bool
     */

    public static function isReverbConfig()
    {
        return cache('has_reverb', null) || config('messaging.reverb', null);
    }


    /**
     * Get the CSS for the Messaging dashboard.
     *
     * @return HtmlString
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
     * @return HtmlString
     */
    public static function js()
    {
        if (($appJs = @file_get_contents(__DIR__ . '/../dist/app.js')) === false) {
            throw new RuntimeException('Unable to load the Messaging dashboard JavaScript.');
        }

        $messaging = Js::from(static::scriptVariables());
        $REVERB_APP_KEY = "'" . env('REVERB_APP_KEY') . "'";
        $REVERB_HOST = "'" . env('REVERB_HOST', '0.0.0.0') . "'";
        $REVERB_PORT = env('REVERB_PORT', 8081);
        $REVERB_SCHEME = "'" . env('REVERB_SCHEME') . "'";

        $isReverbConfig = "'" . static::isReverbConfig() . "'";


        return new HtmlString(<<<HTML
            <script type="module">
                window.Messaging = {$messaging};
                {$appJs};
                const reverbKey = {$REVERB_APP_KEY};
                const isReverbConfig = {$isReverbConfig};

                if(isReverbConfig && reverbKey) {
                    window.Echo = new window.Echo({
                        broadcaster: 'reverb',
                        key: {$REVERB_APP_KEY},
                        wsHost: {$REVERB_HOST},
                        wsPort: {$REVERB_PORT},
                        wssPort: {$REVERB_PORT},
                        forceTLS: ({$REVERB_SCHEME} ?? 'https') === 'https',
                        enabledTransports: ['ws', 'wss']
                    });
                } else {
                    console.warn('[Reverb:] Reverb not configured!')
                }
            </script>
            HTML);
    }
}
