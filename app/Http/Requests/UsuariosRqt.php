<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRqt extends FormRequest
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
        if ($this->segment(5) == "adicionar"){
            return ['login' => 'required|min:3',
                'status' => 'required|string',
                'email' => 'required|string',
                'telefone' => 'required|string',
                'usr_id_setor' => 'required|numeric',
                'usr_id_funcao' => 'required|numeric',
                'cli_id_associado' => 'required|numeric',
                'usr_id_instituicao' => 'required|numeric',
                'usr_id_unidade' => 'required|numeric',
            ];
        }else{
            return ['login' => 'required|min:3|unique:usr_usuarios,login,'.$this->segment(6).',id',
                'status' => 'required|string',
                'usr_id_setor' => 'required|numeric',
                'usr_id_funcao' => 'required|numeric',
                'usr_id_instituicao' => 'required|numeric',
                'usr_id_unidade' => 'required|numeric',
            ];
        }
    }

     public function messages()
    {
        return [
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'O campo :attribute deve possuir no minimo :min caracteres',
        'unique' => 'O :attribute já foi adicionado no banco.',
        'numeric' => 'O campo :attribute só aceita valores númericos.',
        ];
    }
}
