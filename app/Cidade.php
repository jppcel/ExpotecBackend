<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'Cod_Ibge';
    protected $table = 'Cidade';

    public function estado()
    {
      return $this->belongsTo('App\Estado');
    }

    public function CEPs()
    {
      return $this->hasMany('App\CEP');
    }

    public function pessoas()
    {
      return $this->hasMany('App\Pessoa');
    }
}
