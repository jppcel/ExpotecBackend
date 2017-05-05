<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'Id';
    protected $table = 'Pais';

    public function estados()
    {
      return $this->hasMany('App\Estado');
    }
}
