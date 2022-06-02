<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonRequest extends FormRequest
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
                //
                'nombres' => 'required|string',
                'apellidos' => 'required|string',
                'telefono' => 'string|nullable',
                'correo' => 'email|nullable',
                'cedula'=>'required|string|unique:people',
                'tipo'=>['required','string',Rule::in(['V','E'])],
                'municipality_id' => 'required|exists:municipalities,id',
                'vehiculo'  => 'required',
                'vehiculo.placa' => 'required|unique:vehicles,placa'
            ];
        }
        if($this->isMethod('PUT')){
            return [
                //
                'nombres' => 'required|string',
                'apellidos' => 'required|string',
                'telefono' => 'string|nullable',
                'correo' => 'email|nullable',
                'cedula'=>['required','string',Rule::unique('people')->ignore($this->person)],
                'tipo'=>['required','string',Rule::in(['V','E'])],
                'municipality_id' => 'required|exists:municipalities,id',
                'vehiculo'  => 'required',
                'vehiculo.placa' => 'required|unique:vehicles,placa'
            ];
        }

    }

    function messages()
    {
        return [
            'required'  => 'El campo :attribute es requerido',
            'string'    => 'El campo :attribute debe ser un texto',
            'cedula.unique'    => 'La cedula ya está registrada',
            'vehiculo.placa.unique'     => 'La placa ya está registrada',
            'in'        => 'El tipo debe ser: :values',
            'email'     => 'El correo no es valido',
            'exists'    => 'El municipio no existe en la base de datos'
        ];
    }
}
