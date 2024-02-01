<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoDocumentoRequest;
use App\Http\Requests\UpdateTipoDocumentoRequest;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Log;

class TipoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $result = TipoDocumento::all();
            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao listar os tipo documento: " . $e);
            throw new \Exception("Erro ao listar os tipo documento");
        }
    }

    public function store(StoreTipoDocumentoRequest $request)
    {
        try {
            $descricao = $request->input('descricao');
            TipoDocumento::create([
                'descricao' => $descricao,

            ]);

            return response()->json("Cadastro realizado com sucesso!", 200);

        } catch (\Exception $e) {
            Log::debug("Erro ao inserir um tipo de documento: " . $e);
            throw new \Exception("Erro ao inserir um tipo de documento: " . $e->getCode());
        }
    }


    public function show(TipoDocumento $tipo_documento)
    {
        try {
            return response()->json($tipo_documento);
        }catch (\Exception $e) {
            Log::debug("Erro ao mostrar o tipo de documento: " . $e);
            throw new \Exception("Erro ao mostrar o tipo de documento");
        }
    }


    public function update(UpdateTipoDocumentoRequest $request, TipoDocumento $tipo_documento)
    {
        try {

            $tipo_documento->descricao = $request->descricao;
            $result = $tipo_documento->update();

            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao atuailizar tipo_documento: " . $e);
            throw new \Exception("Erro ao atualizar tipo_documento");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDocumento $tipo_documento)
    {
        try {
            $result = $tipo_documento->delete();
            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao deletar o tipo do documento: " . $e);
            throw new \Exception("Erro ao deletar tipo do documento");
        }
    }
}
