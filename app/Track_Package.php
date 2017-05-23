<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track_Package extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Track_Package';

    public function package(){
      return $this->belongsTo("App\Package", "Package_id");
    }

    public function track(){
      return $this->belongsTo("App\Track", "Track_id");
    }
}
