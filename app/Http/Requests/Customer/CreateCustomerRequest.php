<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
        return [
            'cnpj' => 'required|unique:customers,cnpj|max:14|min:14|integer',
            'nome_fantasia' => 'required',
            'razao_social' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'cnpj' => 'CNPJ',
            'nome_fantasia' => 'Nome Fantasia',
            'razao_social' => 'Razão Social'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'Já existe um cadastro com o :attribute informado',
            'max' => 'O campo :attribute precisa ter 14 dígitos',
            'min' => 'O campo :attribute precisa ter 14 dígitos',
            'integer' => 'O campo :attribute precisa ser numérico',
        ];
    }
}
