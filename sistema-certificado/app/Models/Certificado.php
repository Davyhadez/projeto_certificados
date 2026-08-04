<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificado extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pessoa_id',
        'curso_id',
        'data_realizacao',
        'liberado',
        'hash_validacao'
    ];


    protected $casts = [
        'data_realização' => 'date',
        'liberado' => 'boolean',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}