<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerfilRequest;
use App\Http\Requests\UpdatePerfilRequest;
use App\Models\Perfil;
use Illuminate\Support\Facades\Log;


class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        try {
           $result = Perfil::all();
           return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao listar os perfils: " . $e);
            throw new \Exception("Erro ao listar os perfis");
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePerfilRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePerfilRequest $request)
    {

        $descricao = $request->input('descricao');
        $nivel = $request->input('nivel');
        $nome_perfil = $request->input('nome_perfil');
        try {

            Perfil::create([
                'descricao' => $descricao,
                'nivel' => $nivel,
                'nome_perfil' => $nome_perfil
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
     * @param \App\Models\Perfil $perfil
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Perfil $perfil)
    {
        try {
            $result = $perfil;
            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao mostrar o perfil: " . $e);
            throw new \Exception("Erro ao mostrar o perfil");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePerfilRequest $request
     * @param \App\Models\Perfil $perfil
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePerfilRequest $request, Perfil $perfil)
    {
        try {

            $perfil->nome_perfil = $request->nome_perfil;
            $perfil->descricao = $request->descricao;
            $perfil->nivel = $request->nivel;

            $result = $perfil->update();

            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao atuailizar perfil: " . $e);
            throw new \Exception("Erro ao atualizar perfil");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Perfil $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        try {
            $result = $perfil->delete();
            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao deletar o perfil: " . $e);
            throw new \Exception("Erro ao deletar o perfil");
        }

    }
}
