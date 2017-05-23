<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Package';

    public function subscriptions(){
      return $this->hasMany("App\Subscription");
    }

    public function tracks_package(){
      return $this->hasMany("App\Trilha_Pacote");
    }
}
