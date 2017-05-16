<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trilha extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Trilha';

    public function atividades(){
      return $this->hasMany("App\Atividade", "Trilha_id", "id");
    }

    public function trilha_pacote(){
      return $this->hasMany("App\Trilha_Pacote");
    }
}
