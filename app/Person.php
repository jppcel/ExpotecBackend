<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Person';

    public function user()
    {
      return $this->hasOne('App\User');
    }

    public function address()
    {
      return $this->hasOne('App\Address');
    }

    public function phones()
    {
      return $this->hasMany('App\Phone');
    }

    public function packages(){
      return $this->hasMany("App\Subscription");
    }
}
