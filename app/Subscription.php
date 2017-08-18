<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Subscription';

    public function person(){
      return $this->belongsTo("App\Person", "Person_id");
    }

    public function package(){
      return $this->belongsTo("App\Package", "Package_id");
    }

    public function payment(){
      return $this->hasMany("App\Payment", "Subscription_id");
    }

    public function onepayment(){
      return $this->hasOne("App\Payment", "Subscription_id");
    }

    public function checks(){
      return $this->hasMany("App\Check", "Subscription_id");
    }

    public function participates(){
      return $this->hasMany("App\Participation", "Subscription_id");
    }

    public function certificate(){
      return $this->hasOne("App\Certificate", "Subscription_id");
    }
}
