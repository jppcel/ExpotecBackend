<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'Cod_Ibge';
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
