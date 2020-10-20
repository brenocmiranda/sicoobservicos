<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtivoRqt extends FormRequest
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
     * @return array
     */
    public function rules()
    {   
        if($this->segment(4) == 'adicionar'){
            return [
                'nome' => 'required|min:3',
                'n_patrimonio' => 'nullable|string', 
                'serialNumber' => 'required|string', 
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'id_setor' => 'required|numeric',
                'id_unidade' => 'required|numeric',
                'descricao' => 'nullable',
                'imagem_principal' => 'required|image', 
            ];
        }else{
            return [
                'nome' => 'required|min:3',
                'n_patrimonio' => 'nullable|string',
                'serialNumber' => 'required|string', 
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'id_setor' => 'required|numeric',
                'id_unidade' => 'required|numeric',
                'descricao' => 'nullable',
                'imagem_principal' => 'nullable', 
            ];
        }   
    }

    public function messages()
    {   
        return [
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'O campo :attribute deve possuir no minimo :min caracteres',
        'unique' => 'O campo :attribute já foi cadastrado, tente novamente.',
        'numeric' => 'O campo :attribute só aceita valores númericos.',
        ];   
    }
}
