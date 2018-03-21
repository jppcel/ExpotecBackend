<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'PaymentMethod';
}
