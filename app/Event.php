<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Event';

    public function packages()
    {
      return $this->hasMany('App\Package', "Event_id", "id");
    }

    public function tracks()
    {
      return $this->hasMany('App\Track', "Event_id", "id");
    }

    public function activities()
    {
      return $this->hasMany('App\Activity', "Event_id", "id");
    }
}
