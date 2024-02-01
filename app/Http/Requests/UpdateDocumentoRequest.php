<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "tipo_documento_id" => 'required',
            'destinatario_user_id' => 'required',
            'corpo_texto' => 'required',
            'titulo' => 'required',
            'data_prazo' =>  'required',
            'horario_prazo' =>  'required',
        ];
    }
}
