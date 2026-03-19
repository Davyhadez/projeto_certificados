<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table ='usuario';

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'login_usuario',
        'senha_usuario',
        'ativo',
        'id_pessoa',
        'id_tipo_usuario',
    ];

    protected $hidden = [
        'senha_usuario',
    ];
    
    public function getAuthPassword()
    {
        return 'id_usuario';
    }

    public $timestamps = false;
}
