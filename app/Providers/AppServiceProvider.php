<?php

namespace App\Providers;

use App\EntrustModule;
use App\Libraries\Ingenuiti\StringFilter\Facades\StringFilter;
use App\User;
use App\VendorPasswordReset;
use App\VendorStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        Validator::extend('slug', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value);
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }


}
