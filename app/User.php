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
}
