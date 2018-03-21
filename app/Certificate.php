<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Certificate';

    public function subscription(){
      return $this->belongsTo("App\Subscription");
    }
}
