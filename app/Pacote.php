<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Pacote';

    public function pessoa_inscricao_pacote(){
      return $this->hasMany("App\Pessoa_Inscricao_Pacote");
    }

    public function trilha_pacote(){
      return $this->hasMany("App\Trilha_Pacote");
    }
}
