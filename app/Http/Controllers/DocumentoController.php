<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentoRequest;
use App\Http\Requests\UpdateDocumentoRequest;
use App\Models\DocumentoHistorico;
use App\Models\Documentos;
use App\Models\Perfil;
use App\Services\DocumentoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {

            $user_id = Auth::user()->id;
            $result = Documentos::select('documentos.id', 'tipo_documento_id', 'reuniao_id',
                'remetente_user_id', 'destinatario_user_id', 'resposta_documento_id', 'corpo_texto',
                'titulo', 'name', 'numero_documento'
            )->where(function ($query) use ($user_id) {
                $query->where('remetente_user_id', '=', $user_id)
                    ->orWhere('destinatario_user_id', '=', $user_id);
            })->join('users', 'users.id', '=', 'documentos.destinatario_user_id')
                ->leftJoin('reuniaos', 'reuniaos.id', '=', 'documentos.reuniao_id')
                ->join('tipo_documentos', 'tipo_documentos.id', '=', 'documentos.tipo_documento_id')
                ->get();

            return response()->json($result);
        } catch (\Exception $e) {
            Log::debug("Erro ao listar os perfils: " . $e);
            throw new \Exception("Erro ao listar os perfis");
        }

    }


    public function store(StoreDocumentoRequest $request)
    {

        try {

            Documentos::create([
                "tipo_documento_id" => $request->tipo_documento_id,
                "reuniao_id" => $request->reuniao_id,
                "remetente_user_id" => Auth::user()->id,
                'destinatario_user_id' => $request->destinatario_user_id,
                'resposta_documento_id' => $request->resposta_documento_id,
                'corpo_texto' => $request->corpo_texto,
                'numero_documento' => DocumentoService::buscarUltimoNumeroTipoDocumento($request->tipo_documento_id),
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'data_prazo' => $request->data_prazo,
                'horario_prazo' => $request->horario_prazo,
                'protocolo' => Carbon::now(),
            ]);

            return response()->json("Cadastro realizado com sucesso!", 200);

        } catch (\Exception $e) {
            Log::debug("Erro ao inserir um perfil: " . $e);
            throw new \Exception("Erro ao inserir um perfil: " . $e->getCode());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Documentos $documento)
    {
        try {
            $result = Documentos::select('documentos.id', 'reuniao_id', 'tipo_documento_id',
                'remetente_user_id', 'destinatario_user_id', 'resposta_documento_id',
                'corpo_texto', 'numero_documento', 'titulo', 'documentos.descricao', 'data_prazo', 'horario_prazo',
                'protocolo', 'visualizacao', 'tipo_documentos.descricao as tipo_documento',
                'tipo_documentos.descricao as tipo_documento', 'reuniaos.descricao as nome_reuniao')
                ->where('documentos.id', $documento->id)
                ->leftJoin('reuniaos', 'reuniaos.id', '=', 'documentos.reuniao_id')
                ->leftJoin('tipo_documentos', 'tipo_documentos.id', '=', 'documentos.tipo_documento_id')
                ->first();


            return response()->json($result);
        } catch (\Exception $e) {
            Log::debug("Erro ao mostrar o documento: " . $e);
            throw new \Exception("Erro ao mostrar o documento");
        }
    }

    public function mostrarMudanca($id)
    {
        try {
            $result = DocumentoHistorico::select('documento_historicos.id', 'reuniao_id', 'documento_historicos.tipo_documento_id',
                'remetente_user_id', 'documento_historicos.destinatario_user_id', 'resposta_documento_id',
                'documento_historicos.corpo_texto', 'numero_documento', 'documento_historicos.titulo',
                'documento_historicos.descricao', 'documento_historicos.data_prazo', 'documento_historicos.horario_prazo',
                'documentos.protocolo', 'visualizacao', 'tipo_documentos.descricao as tipo_documento',
                'tipo_documentos.descricao as tipo_documento', 'reuniaos.descricao as nome_reuniao')
                ->where('documento_historicos.id', $id)
                ->leftJoin('documentos', 'documentos.id', '=', 'documento_historicos.documento_id')
                ->leftJoin('reuniaos', 'reuniaos.id', '=', 'documentos.reuniao_id')
                ->leftJoin('tipo_documentos', 'tipo_documentos.id', '=', 'documento_historicos.tipo_documento_id')

                ->first();


            return response()->json($result);
        } catch (\Exception $e) {
            Log::debug("Erro ao mostrar o documento: " . $e);
            throw new \Exception("Erro ao mostrar o documento");
        }
    }


    public function update(UpdateDocumentoRequest $request, Documentos $documento)
    {
        try {

            $documento->tipo_documento_id =  $request->tipo_documento_id;
            $documento->reuniao_id = $request->reuniao_id;
            $documento->destinatario_user_id = $request->destinatario_user_id;
            $documento->corpo_texto = $request->corpo_texto;
            $documento->titulo =  $request->titulo;
            $documento->descricao =  $request->descricao;
            $documento->data_prazo = $request->data_prazo;
            $documento->horario_prazo = $request->horario_prazo;

            $result = $documento->update();

            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao atuailizar perfil: " . $e);
            throw new \Exception("Erro ao atualizar perfil");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function registrarVisualizarDocumento(Documentos $documento)
    {
        $result = DocumentoService::visualizar_documento($documento);
        return response()->json($result);
    }


    public function AssinarDocumento()
    {
        $result = DocumentoService::assinarDocumento();
        return response()->json($result);
    }

}
