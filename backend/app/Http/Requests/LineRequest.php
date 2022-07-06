<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LineRequest extends FormRequest
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
        if($this->isMethod('POST')){
            return [
                'name' => 'required|string',
                'rif' => 'nullable|string|unique:lines',
                'municipality_id' => 'required|integer|exists:municipalities,id',
            ];
        }
        if($this->isMethod('PUT')){
            return [
                'name' => 'required|string',
                'rif' => ['nullable','string',Rule::unique('lines')->ignore($this->line)],
                'municipality_id' => 'required|integer|exists:municipalities,id',
            ];
        }
    }

    public function messages()
    {
        return [
            'required'  => 'El campo :attribute es requerido',
            'string'    => 'El campo :attribute debe ser un texto',
            'exists'    => 'El municipio no existe en la base de datos',
            'integer'   => 'El campo :attribute de ser un número',
            'unique'    => 'El rif ya se encuentra registrado'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        custom_failed_validation($validator);
    }


}
