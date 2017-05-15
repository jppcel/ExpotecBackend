<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Atividade';
}
