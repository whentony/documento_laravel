<?php

namespace App\Observers;

use App\Models\Documentos;
use App\Services\DocumentoService;
use Illuminate\Support\Facades\Log;

class DocumentoObserver
{

    /**
     * Handle the Documentos "created" event.
     *
     * @param  \App\Models\Documentos  $documentos
     * @return void
     */
    public function created(Documentos $documentos)
    {
        //
    }

    /**
     * Handle the Documentos "updated" event.
     *
     * @param  \App\Models\Documentos  $documentos
     * @return void
     */
    public function updated(Documentos $documentos)
    {
        DocumentoService::salvarHistorico($documentos->titulo, $documentos->corpo_texto,
            $documentos->descricao, $documentos->id,$documentos->tipo_documento_id,
            $documentos->destinatario_user_id, $documentos->data_prazo, $documentos->horario_prazo);
    }

    /**
     * Handle the Documentos "deleted" event.
     *
     * @param  \App\Models\Documentos  $documentos
     * @return void
     */
    public function deleted(Documentos $documentos)
    {
        //
    }

    /**
     * Handle the Documentos "restored" event.
     *
     * @param  \App\Models\Documentos  $documentos
     * @return void
     */
    public function restored(Documentos $documentos)
    {
        //
    }

    /**
     * Handle the Documentos "force deleted" event.
     *
     * @param  \App\Models\Documentos  $documentos
     * @return void
     */
    public function forceDeleted(Documentos $documentos)
    {
        //
    }
}
