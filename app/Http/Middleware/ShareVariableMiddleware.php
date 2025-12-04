<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\View;
use Closure;

class ShareVariableMiddleware
{

    public function handle($request, Closure $next)
    {
        $setting = GeneralSetting::pluck('value', 'key');
        View::share('general_setting', $setting);
        return $next($request);
    }
}
