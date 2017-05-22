<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Subscription';

    public function people(){
      return $this->belongsTo("App\Person");
    }

    public function packages(){
      return $this->belongsTo("App\Package");
    }

    public function payment(){
      return $this->hasMany("App\Payment", "Subscription_id");
    }
}
