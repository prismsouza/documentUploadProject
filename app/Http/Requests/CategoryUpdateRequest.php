<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            'name.unique' => "Esta categoria já existe",
            'description.required' => "O campo 'descrição' é obrigatório",
            ];
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'hint' => 'nullable'
        ];
    }
}
