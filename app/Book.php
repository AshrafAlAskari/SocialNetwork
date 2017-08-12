<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
   public function user()
   {
      return $this->belongsTo(User::Class);
   }
}
