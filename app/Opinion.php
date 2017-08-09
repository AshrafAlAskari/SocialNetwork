<?php

namespace social_network;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
   public function user()
   {
      return $this->belongsTo('social_network\User');
   }
}
