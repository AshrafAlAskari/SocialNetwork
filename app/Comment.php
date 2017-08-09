<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   public function user()
   {
      return $this->belongsTo('social_network\User');
   }

   public function post()
   {
      return $this->belongsTo('social_network\Post');
   }
}
