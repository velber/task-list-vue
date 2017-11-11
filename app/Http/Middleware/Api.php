<?php

namespace App\Http\Middleware;

use Closure;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $apiKey = config('app.api_key');
        if (! $apiKey) {
            return response('Api key is did not set up on the server!', 400);
        }

        $headers = $request->headers->all();
        if (!array_key_exists('api-key', $headers)) {
            return response('Api key is required', 403);
        }

        if ($headers['api-key'][0] === $apiKey) {
            return $next($request);
        }

        return response('API key or API secret is invalid', 403);
    }
}
