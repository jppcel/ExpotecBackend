<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Package';

    public function subscriptions(){
      return $this->hasMany("App\Subscription");
    }

    public function tracks_package(){
      return $this->hasMany("App\Track_Package");
    }

    public function event(){
      return $this->belongsTo("App\Event", "Event_id");
    }
}
