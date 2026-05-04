<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $table = 'disciplina';
    protected $primaryKey = 'id_disciplina';
    public $timestamps = false;
    protected $fillable = ['nome_disciplina', 'conteudo', 'carga_horaria', 'id_evento'];


    public function evento() {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
