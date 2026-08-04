<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    protected $table = 'lotacao'; 
    protected $fillable = ['nome', 'descricao']; 
}