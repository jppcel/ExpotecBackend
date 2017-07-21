<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityPrivate extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Activity';

    public function speaker(){
      return $this->belongsTo("App\Speaker");
    }

    public function track(){
      return $this->belongsTo("App\Track");
    }
}
