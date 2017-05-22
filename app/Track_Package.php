<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track_Package extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Track_Package';

    public function packages(){
      return $this->belongsTo("App\Package");
    }

    public function tracks(){
      return $this->belongsTo("App\Track");
    }
}
