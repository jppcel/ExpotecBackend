<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'Id';
    protected $table = 'Estado';

    public function pais()
    {
      return $this->belongsTo('App\Pais');
    }

    public function cidades()
    {
      return $this->hasMany('App\Cidade');
    }
}
