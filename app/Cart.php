<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Cart';

    public function Package()
    {
      return $this->belongsTo('App\Package', "Package_id");
    }
}
