<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CEP extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'CEP';

    public function cidade()
    {
      return $this->belongsTo('App\Cidade');
    }
}
