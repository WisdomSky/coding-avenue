<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

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


}
