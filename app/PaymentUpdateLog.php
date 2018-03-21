<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentUpdateLog extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'PaymentUpdateLog';

    public function user(){
      return $this->belongsTo("App\User", "User_id");
    }

    public function payment(){
      return $this->belongsTo("App\Payment", "Payment_id");
    }
}
