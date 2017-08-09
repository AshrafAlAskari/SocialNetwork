<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Going extends Model
{
   public function user()
   {
      return $this->belongsTo('social_network\User');
   }

   public function event()
   {
      return $this->belongsTo('social_network\Event');
   }
}
