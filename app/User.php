<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'User';

    public function person(){
      return $this->belongsTo("App\Person", "Person_id");
    }

    public function permissions(){
      return $this->hasMany("App\UserPermission");
    }

    public function paymentUpdate(){
      return $this->hasMany("App\PaymentUpdateLog");
    }

    public function log(){
      return $this->hasMany("App\Log");
    }
}
