<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa_Inscricao_Pacote extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Pessoa_Inscricao_Pacote';

    public function pessoas(){
      return $this->belongsTo("App\Pessoa");
    }

    public function pacotes(){
      return $this->belongsTo("App\Pacote");
    }

    public function pagamento(){
      return $this->hasMany("App\Pagamento");
    }
}
