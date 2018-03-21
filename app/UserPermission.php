<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'UserPermission';

    public function user(){
      return $this->belongsTo("App\User", "User_id");
    }

    public function permission(){
      return $this->belongsTo("App\Permission", "Permission_id");
    }
}
