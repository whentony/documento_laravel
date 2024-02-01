<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $result = User::select('users.id', 'users.name', 'users.email', 'users.telefone_celular', 'perfils.nome_perfil' )->join('perfils', 'perfils.id', '=', 'users.perfil_id')->get();
            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao listar os usuarios: " . $e);
            throw new \Exception("Erro ao listar os usuarios");
        }
    }

    public function store(StoreUserRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $perfil_id = $request->input('perfil_id');
        $tratamento = $request->input('tratamento');
        $inicio_mandato = $request->input('inicio_mandato');
        $fim_mandato = $request->input('fim_mandato');
        $aniversario = $request->input('aniversario');
        $telefone_comercial = $request->input('telefone_comercial');
        $telefone_residencial = $request->input('telefone_residencial');
        $telefone_celular = $request->input('telefone_celular');

        $senha = bcrypt($request->input('senha'));
        try {

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => $senha,
                'perfil_id' => $perfil_id,
                'tratamento' => $tratamento,
                'inicio_mandato' => $inicio_mandato,
                'fim_mandato' => $fim_mandato,
                'aniversario' => $aniversario,
                'telefone_comercial' => $telefone_comercial,
                'telefone_residencial' => $telefone_residencial,
                'telefone_celular' => $telefone_celular
            ]);

            return response()->json("Cadastro realizado com sucesso!", 200);

        } catch (\Exception $e) {
            Log::debug("Erro ao inserir um usuario: " . $e);
            throw new \Exception("Erro ao inserir um usuario: " . $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $result = User::find($id);
            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao mostrar o usuario: " . $e);
            throw new \Exception("Erro ao mostrar o usuario");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {

            $user = User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->perfil_id = $request->perfil_id;

            if(!is_null($request->senha)){
                $user->senha = bcrypt($request->senha);
            }

            $user->tratamento = $request->tratamento;
            $user->inicio_mandato = $request->inicio_mandato;
            $user->fim_mandato = $request->fim_mandato;
            $user->aniversario = $request->aniversario;
            $user->telefone_comercial = $request->telefone_comercial;
            $user->telefone_residencial = $request->telefone_residencial;
            $user->telefone_celular = $request->telefone_celular;

            $result = $user->update();

            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao atuailizar perfil: " . $e);
            throw new \Exception("Erro ao atualizar perfil");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $result = $user->delete();
            return response()->json($result);
        }catch (\Exception $e) {
            Log::debug("Erro ao deletar o usuario: " . $e);
            throw new \Exception("Erro ao usuario o perfil");
        }
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login (Request $request) {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // successfull authentication

            $user = User::select('users.id', 'users.name',
                'users.email', 'users.email_verified_at', 'users.email_verified_at', 'users.tratamento',
                'users.inicio_mandato','users.fim_mandato','users.aniversario','users.telefone_comercial',
                'users.telefone_residencial','users.telefone_celular','users.created_at',
                'perfils.nome_perfil as perfil' )
                ->join('perfils', 'perfils.id', '=', 'users.perfil_id')->first();

            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }

    public function validateToken() {
        $user = User::find(Auth::user()->id);
        return $user;
    }

    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
    }


    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('TutsForWeb')->accessToken;

        return response()->json(['token' => $token], 200);
    }

}
