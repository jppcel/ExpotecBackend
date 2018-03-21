<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Participation';
}
