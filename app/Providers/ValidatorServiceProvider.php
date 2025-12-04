<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('maxwords', function ($attribute, $value, $parameters, $validator) {
            $words = preg_split('@\s+@i', trim($value));
            if (count($words) <= $parameters[0]) {
                return true;
            }
            return false;
        });
        Validator::replacer('maxwords', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':maxwords', $parameters[0], $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
