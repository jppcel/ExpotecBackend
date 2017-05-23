<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Person';

    public function city()
    {
      return $this->belongsTo('App\City', 'City_Cod_Ibge');
    }

    public function user()
    {
      return $this->hasOne('App\User');
    }

    public function address()
    {
      return $this->hasOne('App\Address');
    }

    public function packages(){
      return $this->hasMany("App\Subscription");
    }
}
