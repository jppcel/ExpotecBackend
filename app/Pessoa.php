<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'Pessoa';

    public function cidade()
    {
      return $this->belongsTo('App\Cidade');
    }

    public function pacotes(){
      return $this->hasMany("App\Pessoa_Inscricao_Pacote");
    }
}
