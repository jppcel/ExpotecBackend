<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Phone';

    public function Person(){
      return $this->belongsTo("App\Person");
    }
}
