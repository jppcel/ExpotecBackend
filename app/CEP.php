<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CEP extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'CEP';

    public function cidade()
    {
      return $this->belongsTo('App\Cidade');
    }
}
