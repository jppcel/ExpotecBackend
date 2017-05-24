<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeStreet extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'TypeStreet';

    public function Addresses(){
      return $this->hasMany("App\Address", "Address_id", "id");
    }
}
