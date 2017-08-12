<?php

namespace social_network;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    public function posts()
    {
        return $this->hasMany(Post::Class);
    }

    public function likes()
    {
        return $this->hasMany(Like::Class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::Class);
    }

    public function goings()
    {
        return $this->hasMany(Going::Class);
    }

    public function books()
    {
      return $this->hasMany(Book::Class);
   }

   public function opinions()
   {
      return $this->hasmany(Opinion::Class);
   }
}
