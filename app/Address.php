<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Address';

    public function person(){
      return $this->belongsTo("App\Person");
    }

    public function typestreet(){
      return $this->belongsTo("App\TypeStreet");
    }

    public function city(){
      return $this->belongsTo("App\City", "City_id");
    }
}
