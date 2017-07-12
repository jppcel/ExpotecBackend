<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'ResetPassword';

    public function person(){
      return $this->belongsTo("App\Person");
    }
}
