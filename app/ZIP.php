<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZIP extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'ZIP';

    public function typeStreet(){
      return $this->belongsTo("App\TypeStreet", "TypeStreet_id");
    }

    public function city(){
      return $this->belongsTo("App\City", "City_id");
    }
}
