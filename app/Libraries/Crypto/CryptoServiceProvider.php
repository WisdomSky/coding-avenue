<?php
/**
 * Created by PhpStorm.
 * User: webdev
 * Date: 6/2/2017
 * Time: 3:54 PM
 */

namespace App\Libraries\Crypto;

use Illuminate\Support\ServiceProvider;

class CryptoServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('vp.crypto', function ($app) {
            return new CryptoClass;
        });
    }

}
