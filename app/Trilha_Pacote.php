<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trilha_Pacote extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Trilha_Pacote';

    public function pacotes(){
      return $this->belongsTo("App\Pacote");
    }

    public function trilhas(){
      return $this->belongsTo("App\Trilha");
    }
}
