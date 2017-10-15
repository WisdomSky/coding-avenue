<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Post extends Authenticatable
{

    protected $table = 'posts';

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'title', 'slug', 'content', 'type', 'user_id',
    ];

    const TYPE_PUBLISHED = 'published';
    const TYPE_DRAFT = 'draft';
    const TYPE_DELETED= 'deleted';

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOwnedByAuthUser($query)
    {
        return $query->where('user_id', Auth::user()->getKey());
    }


}
