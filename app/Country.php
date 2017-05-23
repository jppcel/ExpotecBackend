<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Country';

    public function states()
    {
      return $this->hasMany('App\State');
    }
}
