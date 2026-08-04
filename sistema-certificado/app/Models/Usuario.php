<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable {

    use HasFactory;

    public $timestamps = false;
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'login_usuario',
        'senha_usuario',
        'ativo',
        'id_pessoa',
        'id_tipo_usuario'
    ];
    protected $hidden = [
        'senha_usuario'
    ];


    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function lotacao() {
        
        return $this->hasOneThrough(
            Lotacao::class,
            Pessoa::class,
            'id_pessoa',      
            'id_lotacao',    
            'id_pessoa',      
            'id_lotacao'     
        );
    }

    public function getTipoNomeAttribute()
    {
        return match((int)$this->id_tipo_usuario) {
            1 => 'Administrador',
            2 => 'Treinamento',
            3 => 'Gabinete',
            default => 'Outros',
        };
    }
}
