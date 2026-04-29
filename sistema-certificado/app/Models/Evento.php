<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoEvento;
use App\Models\Disciplina;

class Evento extends Model
{
    protected $table = 'evento';
    protected $primaryKey = 'id_evento';
    protected $fillable = ['nome_evento', 'carga_horaria', 'id_tipo_evento', 'ativo']; 
    public $timestamps = false;

    public function tipo()
    {
        return $this->belongsTo(TipoEvento::class, 'id_tipo_evento');
    }


    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class, 'id_evento');
    }
}