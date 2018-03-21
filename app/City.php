<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'City';

    public function state()
    {
      return $this->belongsTo('App\State', 'State_id');
    }

    public function people()
    {
      return $this->hasMany('App\Person');
    }
}
