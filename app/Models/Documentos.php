<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory, HasEvents;

    protected $fillable = [
        "tipo_documento_id",
        "reuniao_id",
        "remetente_user_id",
        'destinatario_user_id',
        'resposta_documento_id',
        'corpo_texto',
        'numero_documento',
        'titulo',
        'descricao',
        'data_prazo',
        'horario_prazo',
        'protocolo',
        'visualizacao'
    ];

    protected $casts = [
        'created_at'  => 'datetime:d/m/Y H:00',
        'updated_at' => 'datetime:d/m/Y H:00',
    ];
}
