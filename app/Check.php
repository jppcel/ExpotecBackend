<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Check';

    public function user()
    {
      return $this->belongsTo('App\User', "User_id");
    }

    public function subscription()
    {
      return $this->belongsTo('App\Subscription', "Subscription_id");
    }

    public function activity()
    {
      return $this->belongsTo('App\Activity', "Activity_id");
    }
}
