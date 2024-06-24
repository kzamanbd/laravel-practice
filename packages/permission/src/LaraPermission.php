<?php

namespace Draftscripts\Permission;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
     * The CSS paths to include on the dashboard.
     *
     * @var list<string|Htmlable>
     */
    protected $css = [__DIR__ . '/../dist/permission.css'];


    /**
     * Register or return CSS for the Pulse dashboard.
     *
     * @param string|Htmlable|list<string|Htmlable>|null $css
     */
    public function css(string|Htmlable|array|null $css = null): string|self
    {
        if (func_num_args() === 1) {
            $this->css = array_values(array_unique(array_merge($this->css, Arr::wrap($css)), SORT_REGULAR));

            return $this;
        }

        return collect($this->css)->reduce(function ($carry, $css) {
            if ($css instanceof Htmlable) {
                return $carry . Str::finish($css->toHtml(), PHP_EOL);
            } else {
                if (($contents = @file_get_contents($css)) === false) {
                    throw new RuntimeException("Unable to load Pulse dashboard CSS path [$css].");
                }

                return $carry . "<style>{$contents}</style>" . PHP_EOL;
            }
        }, '');
    }

    /**
     * Return the compiled JavaScript from the vendor directory.
     */
    public function js(): string
    {
        if (
            ($livewire = @file_get_contents(__DIR__ . '/../../../livewire/livewire/dist/livewire.js')) === false &&
            ($livewire = @file_get_contents(__DIR__ . '/../vendor/livewire/livewire/dist/livewire.js')) === false) {
            throw new RuntimeException('Unable to load the Livewire JavaScript.');
        }

        if (($pulse = @file_get_contents(__DIR__ . '/../dist/permission.js')) === false) {
            throw new RuntimeException('Unable to load the Pulse dashboard JavaScript.');
        }

        return "<script>{$livewire}</script>" . PHP_EOL . "<script>{$pulse}</script>" . PHP_EOL;
    }

    public function userModel()
    {
        return config('lara-permission.models.user');
    }
}
