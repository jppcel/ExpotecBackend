<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Speaker';

    public function activities()
    {
      return $this->hasMany('App\Activity');
    }
}
