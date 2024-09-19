<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {

        $factory->macro('success', function ($data = null) use ($factory) {

            if ($data == NULL) {
                $data = collect();
            }

            $format = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => $data,
            ];

            return $factory->make($format);
        });

        $factory->macro('error', function ($code, $data = null) use ($factory) {

            if ($data == NULL) {
                $data = collect();
            }

            $format = [
                'code'    => $code,
                'message' => 'Error',
                'data'    => (object) $data,
            ];

            return $factory->make($format);
        });

        $factory->macro('customError', function ($code, $message) use ($factory) {
            $format = [
                'code'    => $code,
                'message' => ucwords($message),
                'data'    => null,
            ];

            return $factory->make($format);
        });

        $factory->macro('httpError', function ($code) use ($factory) {
            $format = [
                'code'    => $code,
                'message' => ucwords(str_replace('_', ' ', strtolower(\Symfony\Component\HttpFoundation\Response::$statusTexts[$code]))),
                'data'    => null,
            ];

            return $factory->make($format, $code);
        });

        $factory->macro('datatables', function ($data) use ($factory) {

            if ($data == NULL) {
                $data = collect();
            }

            return $factory->make($data);
        });
    }
}
