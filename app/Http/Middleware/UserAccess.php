<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class UserAccess
{

    // public function handle($request, Closure $next)
    // {
    //     $general_setting = getGeneralSettingByKey();
    //     $lang = getDefaultLanguage(true);
    //     $currentUrl = langBasedURL($lang, Request::url());
    //     // if(Request::url() != route('user.payment.index')){
    //     //     $currentUrl = langBasedURL($lang, Request::url());
    //     // }
    //     // else{
    //     //     $currentUrl = Request::url();
    //     // }
    //     $payment_page = route('user.payment.index', [$lang->abbreviation]);
    //     $user_signin_page = isset($general_setting['user_signin_page']) ? langBasedURL($lang, url($general_setting['user_signin_page'])) : null;
    //     $user_signup_page = isset($general_setting['user_signup_page']) ? langBasedURL($lang, url($general_setting['user_signup_page'])) : null;
    //     $user_event_listing_page = isset($general_setting['user_event_listing_page']) ? langBasedURL($lang, url($general_setting['user_event_listing_page'])) : null;

    //     if (Auth::guard('customers')->check()) {
    //         $customer = Auth::guard('customers')->user();
    //         if ($customer->type == 'event') {
    //             if ($currentUrl == $user_signin_page || $currentUrl == $user_signup_page || $currentUrl == langBasedURL($lang, route('user.profile-settings.index')) || $currentUrl == langBasedURL($lang, route('user.media-setting.index')) || $currentUrl == langBasedURL($lang, route('user.buissness-settings.index')) || $currentUrl == langBasedURL($lang, route('user.social-media-settings.index'))) {
    //                 return Redirect::to($user_event_listing_page);
    //             }
    //             // return Redirect::to($user_event_listing_page);
    //         } else if (!$customer->is_package_amount_paid && $currentUrl != $payment_page) {
    //             return redirect()->route('user.payment.index', [$lang->abbreviation]);
    //         } else if ($currentUrl == $user_signup_page || $currentUrl == $user_signin_page) {
    //             return Redirect::to(langBasedURL($lang, route('user.profile-settings.index')));
    //         }
    //         return $next($request);
    //     } else {
    //         if ($currentUrl != $user_signup_page && $currentUrl != $user_signin_page && Request::url() != route('web.user.login')) {
    //             return Redirect::to($user_signin_page);
    //         }
    //     }
    //     return $next($request);
    // }
    // public function handle($request, Closure $next)
    // {
    //     $general_setting = getGeneralSettingByKey();
    //     $lang = getDefaultLanguage(true);
    //     $currentUrl = langBasedURL($lang, Request::url());

    //     $user_signin_page = isset($general_setting['user_signin_page']) ? langBasedURL($lang, url($general_setting['user_signin_page'])) : null;
    //     $user_signup_page = isset($general_setting['user_signup_page']) ? langBasedURL($lang, url($general_setting['user_signup_page'])) : null;

    //     if (Auth::guard('customers')->check()) {
    //         $customer = Auth::guard('customers')->user();

    //         // Prevent access to signin/signup pages for logged in users
    //         if ($currentUrl == $user_signup_page || $currentUrl == $user_signin_page) {
    //             return Redirect::to(langBasedURL($lang, route('user.profile-settings.index')));
    //         }

    //         return $next($request);
    //     } else {
    //         // Only redirect guests if they're trying to access protected pages
    //         // Add any protected routes that should require authentication here
    //         $protectedRoutes = [
    //             route('user.profile-settings.index'),
    //             route('user.media-setting.index'),
    //             route('user.buissness-settings.index'),
    //             route('user.social-media-settings.index'),
    //             route('user.payment.index'),
    //             // Add any other protected routes here
    //         ];

    //         $protectedUrls = array_map(function($route) use ($lang) {
    //             return langBasedURL($lang, $route);
    //         }, $protectedRoutes);

    //         if (in_array($currentUrl, $protectedUrls)) {
    //             return Redirect::to($user_signin_page);
    //         }
    //     }

    //     return $next($request);
    // }
    public function handle($request, Closure $next)
{
    $general_setting = getGeneralSettingByKey();
    $lang = getDefaultLanguage(true);
    $currentUrl = langBasedURL($lang, Request::url());
    $payment_page = route('user.payment.index', [$lang->abbreviation]);
    $home_page = route('front.index');

    $user_signin_page = isset($general_setting['user_signin_page'])
        ? langBasedURL($lang, url($general_setting['user_signin_page']))
        : null;

    $user_signup_page = isset($general_setting['user_signup_page'])
        ? langBasedURL($lang, url($general_setting['user_signup_page']))
        : null;

    if (Auth::guard('customers')->check()) {
        $customer = Auth::guard('customers')->user();

        // Block signin/signup pages for logged in users
        if ($currentUrl == $user_signup_page || $currentUrl == $user_signin_page) {
            return Redirect::to(langBasedURL($lang, route('user.profile-settings.index')));
        }

        // Handle event type users
        if ($customer->type == 'event') {
            $restrictedUrls = [
                $user_signin_page,
                $user_signup_page,
                langBasedURL($lang, route('user.profile-settings.index')),
                langBasedURL($lang, route('user.media-setting.index')),
                langBasedURL($lang, route('user.buissness-settings.index')),
                langBasedURL($lang, route('user.social-media-settings.index'))
            ];

            if (in_array($currentUrl, $restrictedUrls)) {
                // For unpaid event users, redirect to payment page
                if (!$customer->is_package_amount_paid) {
                    return redirect()->route('user.payment.index', [$lang->abbreviation]);
                }
                // For paid event users, redirect to home page
                return Redirect::to(langBasedURL($lang, $home_page));
            }
        }

        // Redirect unpaid users to payment page for all protected routes except payment page itself
        if (!$customer->is_package_amount_paid) {
            $protectedRoutes = [
                route('user.profile-settings.index'),
                route('user.media-setting.index'),
                route('user.buissness-settings.index'),
                route('user.social-media-settings.index'),
            ];

            $protectedUrls = array_map(function($route) use ($lang) {
                return langBasedURL($lang, $route);
            }, $protectedRoutes);

            if (in_array($currentUrl, $protectedUrls) && $currentUrl != $payment_page) {
                return redirect()->route('user.payment.index', [$lang->abbreviation]);
            }
        }

        return $next($request);
    } else {
        // Handle guest users
        $protectedRoutes = [
            route('user.profile-settings.index'),
            route('user.media-setting.index'),
            route('user.buissness-settings.index'),
            route('user.social-media-settings.index'),
            route('user.payment.index'),
        ];

        $protectedUrls = array_map(function($route) use ($lang) {
            return langBasedURL($lang, $route);
        }, $protectedRoutes);

        if (in_array($currentUrl, $protectedUrls)) {
            return Redirect::to($user_signin_page);
        }
    }

    return $next($request);
}
}
