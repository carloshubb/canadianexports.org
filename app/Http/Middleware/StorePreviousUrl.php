<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class StorePreviousUrl
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
        if ($request->isMethod('get') && !$this->isAuthRoute($request->path())) {
            Session::put('url.intended', $request->fullUrl());
        }

        return $next($request);
    }

    /**
     * Determine if the request is to an authentication route.
     *
     * @param  string  $path
     * @return bool
     */
    protected function isAuthRoute($path)
    {
        // Define common segments or patterns for authentication routes
        $authSegments = ['login', 'signin', 'register', 'password'];

        foreach ($authSegments as $segment) {
            if (strpos($path, $segment) !== false) {
                return true;
            }
        }

        return false;
    }
}
