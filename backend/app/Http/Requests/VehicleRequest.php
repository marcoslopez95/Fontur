<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
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
        if($this->isMethod('post')){
            return [
                'person_id' => 'nullable',
                'placa' => 'string|unique:vehicles',
                'type_fuel' => ['string', Rule::in(['Gasolina','Diesel','Eléctrico'])],
                'num_controller'    => 'string',
                'line_id' => 'required|exists:lines,id'
            ];
        }
        if($this->isMethod('put')){
            return [
                'person_id' => 'nullable',
                'placa' => ['string',Rule::unique('vehicles')->ignore($this->vehicle)],
                'type_fuel' => ['string', Rule::in(['Gasolina','Diesel','Eléctrico'])],
                'num_controller'    => 'string',
                'line_id' => 'required|exists:lines,id'
            ];
        }
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser texto',
            'unique' => 'La placa ya existe en la base de datos',
            'in' => 'El tipo de combustible debe ser: :values',
            'exists' => 'La línea no existe en la base de datos'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        custom_failed_validation($validator);
    }
}
