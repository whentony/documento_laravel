<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoHistorico extends Model
{
    use HasFactory, HasEvents;

    protected $fillable = [
        'documento_id',
        'tipo_documento_id',
        'destinatario_user_id',
        'corpo_texto',
        'titulo',
        'descricao',
        "data_prazo",
        "horario_prazo"
    ];

    protected $casts = [
        'created_at'  => 'datetime:d/m/Y H:00',
        'updated_at' => 'datetime:d/m/Y H:00',
    ];
}
