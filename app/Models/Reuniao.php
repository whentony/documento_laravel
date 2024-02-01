<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniao extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'descricao',
        'data',
        'horario',
        'participantes',
        'pauta'
    ];
}
