<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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

    public function messages()
    {
        return [
            'name.required' => "O campo 'nome' é obrigatório",
            'name.unique' => "Esta tag já existe",
            ];
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:tags'
        ];
    }
}
