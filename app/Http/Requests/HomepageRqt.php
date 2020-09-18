<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomepageRqt extends FormRequest
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
        return ['titulo' => 'required|min:3|string',
            'subtitulo' => 'nullable|string',
            'endereco' => 'required|string',
            'upload_img' => 'nullable|image',
        ];
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
