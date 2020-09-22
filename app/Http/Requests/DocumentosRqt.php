<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentosRqt extends FormRequest
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
            return ['nome' => 'required|min:3',
                'id_arquivo' => 'required|file',
            ];
        }else{
            return ['nome' => 'required|min:3',
                'id_arquivo' => 'nullable|file',
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
