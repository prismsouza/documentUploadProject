<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
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
            'category_id.required' => "O campo 'categoria' é obrigatório",
            'name.required' => "O campo 'nome' é obrigatório",
            'description.required' => "O campo 'descrição' é obrigatório",
            'date.required' => "O campo 'data de publicação' é obrigatório",
            'is_active.required' => "O campo 'vigência' é obrigatório",
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'is_active' => 'required',
            'tags' => 'exists:tags,id'
        ];
    }
}
