<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserStatus
{

    public function handle($request, Closure $next)
    {
        if (Auth::guard('customers')->check()) {
            $user = Auth::guard('customers')->user();
            
            if (!empty($user->deleted_at)) {
                Auth::guard('customers')->logout();
    
                $general_setting = getGeneralSettingByKey();
                $url = langBasedURL(null, $general_setting['user_signin_page']);
    
                return Redirect::to($url);
            }
        }

        return $next($request);
    }
}
