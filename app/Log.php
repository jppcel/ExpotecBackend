<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Log';

    public function user(){
      return $this->belongsTo("App\User", "User_id");
    }
}
