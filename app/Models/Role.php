<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'roles';

    protected $primaryKey = 'role_id';

    public $timestamps = false;

    const ROLE_ADMIN = 'admin';
    const ROLE_WRITER = 'writer';


    protected $fillable = [
        'email', 'role'
    ];


}
