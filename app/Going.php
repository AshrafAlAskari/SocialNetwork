<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Going extends Model
{
   public function user()
   {
      return $this->belongsTo(User::Class);
   }

   public function event()
   {
      return $this->belongsTo(Event::Class);
   }
}
