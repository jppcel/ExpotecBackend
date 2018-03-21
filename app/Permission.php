<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Permission';
}
