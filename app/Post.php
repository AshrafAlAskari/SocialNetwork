<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function likes()
    {
        return $this->hasMany(Like::Class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::Class);
    }
}
