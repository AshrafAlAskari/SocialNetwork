<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
   public function user()
   {
      return $this->belongsTo(User::Class);
   }

   public function goings()
   {
      return $this->hasMany(Going::Class);
   }
}
