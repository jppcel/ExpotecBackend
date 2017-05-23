<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription_Activity extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Subscription_Activity';

    public function subscription(){
      return $this->belongsTo("App\Subscription");
    }

    public function activity(){
      return $this->belongsTo("App\Activity");
    }
}
