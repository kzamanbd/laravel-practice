<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BeforeResponseInterceptor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true); // Get response data as array

            // Transform snake_case to camelCase
            $transformedData = $this->transformKeysToCamelCase($data);

            // Set the transformed data back into the response
            $response->setData($transformedData);
        }

        return $response;
    }

    protected function transformKeysToCamelCase(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $camelCaseKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            if (is_array($value)) {
                // Recursively transform nested arrays
                $result[$camelCaseKey] = $this->transformKeysToCamelCase($value);
            } else {
                // Assign value directly
                $result[$camelCaseKey] = $value;
            }
        }
        return $result;
    }
}
