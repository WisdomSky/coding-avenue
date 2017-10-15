<?php
/**
 * Created by PhpStorm.
 * User: webdev
 * Date: 6/2/2017
 * Time: 3:56 PM
 */

namespace App\Libraries\Crypto;


use Illuminate\Support\Facades\Facade;

class Crypto extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vp.crypto';
    }

}
