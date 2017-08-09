<?php

namespace social_network;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    public function posts()
    {
        return $this->hasMany('social_network\Post');
    }

    public function likes()
    {
        return $this->hasMany('social_network\Like');
    }

    public function comments()
    {
        return $this->hasMany('social_network\Comment');
    }

    public function goings()
    {
        return $this->hasMany('social_network\Going');
    }

    public function books()
    {
      return $this->hasMany('social_network\Book');
   }

   public function opinions()
   {
      return $this->hasmany('social_network\Opinion');
   }
}
