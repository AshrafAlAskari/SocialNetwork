<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('social_network\User');
    }

    public function likes()
    {
        return $this->hasMany('social_network\Like');
    }

    public function comments()
    {
        return $this->hasMany('social_network\Comment');
    }
}
