<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentoHistoricoRequest;
use App\Http\Requests\UpdateDocumentoHistoricoRequest;
use App\Models\DocumentoHistorico;
use App\Models\Documentos;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DocumentoHistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocumentoHistoricoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentoHistoricoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentoHistorico  $documentoHistorico
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentoHistorico $documentoHistorico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentoHistorico  $documentoHistorico
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentoHistorico $documentoHistorico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDocumentoHistoricoRequest  $request
     * @param  \App\Models\DocumentoHistorico  $documentoHistorico
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentoHistoricoRequest $request, DocumentoHistorico $documentoHistorico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentoHistorico  $documentoHistorico
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentoHistorico $documentoHistorico)
    {
        //
    }

    public function pegarHistoricoPorDocumento(Documentos $documento) {

        try {

           $result =  DocumentoHistorico::where('documento_id', $documento->id)->get();

           return response()->json($result);

        }catch (\Exception $e) {
            Log::debug("Erro ao pegar histórico" . $e);
            throw new \Exception("Erro ao pegar histórico");
        }

    }
}
