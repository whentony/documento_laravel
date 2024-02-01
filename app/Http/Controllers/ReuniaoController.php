<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReuniaoRequest;
use App\Http\Requests\UpdateReuniaoRequest;
use App\Models\Reuniao;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReuniaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $result = Reuniao::select('reuniaos.id', 'reuniaos.descricao', 'users.name as usuario',
                'reuniaos.data', 'reuniaos.horario')
                ->join('users', 'users.id', '=', 'reuniaos.user_id')->get();
            return response()->json($result);
        } catch (\Exception $e) {
            Log::debug("Erro ao listar reunioes: " . $e);
            throw new \Exception("Erro ao listar reunioes");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreReuniaoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReuniaoRequest $request)
    {
        try {
            Reuniao::create([
                'user_id' => Auth::user()->id,
                'descricao' => $request->input("descricao"),
                'data' => $request->input("data"),
                'horario' => $request->input("horario"),
                'participantes' => $request->input("participantes"),
                'pauta' => $request->input("pauta")

            ]);

            return response()->json("Cadastro realizado com sucesso!", 200);

        } catch (\Exception $e) {
            Log::debug("Erro ao inserir um tipo de documento: " . $e);
            throw new \Exception("Erro ao inserir um tipo de documento: " . $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reuniao $reuniao
     * @return \Illuminate\Http\Response
     */
    public function show(Reuniao $reuniao)
    {
        try {
            return response()->json($reuniao);
        } catch (\Exception $e) {
            Log::debug("Erro ao mostrar o tipo de documento: " . $e);
            throw new \Exception("Erro ao mostrar o tipo de documento");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateReuniaoRequest $request
     * @param \App\Models\Reuniao $reuniao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReuniaoRequest $request, Reuniao $reuniao)
    {
        try {

            $reuniao->user_id = Auth::user()->id;
            $reuniao->descricao = $request->descricao;
            $reuniao->data = $request->data;
            $reuniao->horario = $request->horario;
            $reuniao->participantes = $request->participantes;
            $reuniao->pauta = $request->pauta;

            $result = $reuniao->update();

            return response()->json($result);
        } catch (\Exception $e) {
            Log::debug("Erro ao atuailizar tipo_documento: " . $e);
            throw new \Exception("Erro ao atualizar tipo_documento");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reuniao $reuniao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reuniao $reuniao)
    {
        try {
            $result = $reuniao->delete();
            return response()->json($result);
        } catch (\Exception $e) {
            Log::debug("Erro ao deletar o tipo do documento: " . $e);
            throw new \Exception("Erro ao deletar tipo do documento");
        }
    }
}
