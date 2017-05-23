<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Product';

    public function track(){
      return $this->belongsTo("App\Track");
    }
}
