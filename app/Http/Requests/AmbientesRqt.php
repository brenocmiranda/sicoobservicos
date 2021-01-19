<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmbientesRqt extends FormRequest
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
        if($this->segment(5) == 'adicionar'){
            return ['nome' => 'required|min:3|unique:gti_ambientes,nome',
                'descricao' => 'nullable|string',
                'status' => 'nullable',
            ];
        }else{
            return ['nome' => 'required|min:3|unique:gti_ambientes,nome,'.$this->segment(6).',id',
                'descricao' => 'nullable|string',
                'status' => 'nullable',
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
