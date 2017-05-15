<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Pagamento';

    public function Pessoa_Inscricao_Pacote(){
      return $this->belongsTo("App\Pessoa_Inscricao_Pacote");
    }
}
