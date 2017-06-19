<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Payment';

    public function Subscription(){
      return $this->belongsTo("App\Subscription", "Subscription_id");
    }
}
