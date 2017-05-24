<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZIP extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'ZIP';
}
