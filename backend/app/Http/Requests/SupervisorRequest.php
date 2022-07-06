<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class SupervisorRequest extends FormRequest
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
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'ci' => 'required|string|unique:supervisors',
                'regional' => 'required|boolean',
                'municipality_id' => 'nullable|integer|exists:municipalities,id',
            ];
        }
        if($this->isMethod('PUT')){
            return [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'ci' => ['required','string',Rule::unique('supervisors')->ignore($this->supervisor)],
                'regional' => 'required|boolean',
                'municipality_id' => 'nullable|integer|exists:municipalities,id',
            ];
        }
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser un texto',
            'integer' => 'El campo :attribute debe ser un número',
            'unique' => 'Ya existe la cédula en la base de datos',
            'boolean' => 'El campo :attribute debe ser un booleano',
            'exists' => 'El campo :attribute no existe en la base de datos'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        custom_failed_validation($validator);
    }
}
