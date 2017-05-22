<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Address';

    public function Person(){
      return $this->belongsTo("App\Person");
    }

    public function TypeStreet(){
      return $this->belongsTo("App\TypeStreet");
    }

    public function City(){
      return $this->belongsTo("App\City");
    }
}
