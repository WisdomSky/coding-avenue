<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'avatar_url',
    ];


    public function getRememberToken()
    {
        return null; // not supported
    }

    public function setRememberToken($value)
    {
        // not supported
    }


}
