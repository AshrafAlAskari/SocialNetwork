<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
   public function user()
   {
      return $this->belongsTo('social_network\User');
   }

   public function goings()
   {
      return $this->hasMany('social_network\Going');
   }
}
