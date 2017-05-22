<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Track';

    public function activities(){
      return $this->hasMany("App\Activity", "Track_id", "id");
    }

    public function track_package(){
      return $this->hasMany("App\Track_Package");
    }
}
