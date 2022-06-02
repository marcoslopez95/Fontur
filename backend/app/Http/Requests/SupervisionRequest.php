<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupervisionRequest extends FormRequest
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
        if ($this->isMethod('post'))
            return [
                'vehicles' => 'required|array',
                'vehicles.*.id' => 'required|integer|exists:vehicles,id|distinct',
                'vehicles.*.active' => 'required|boolean',
                'date' => 'required|date'
            ];
        if ($this->isMethod('put'))
            return [
                'vehicle_id' => 'required|integer|exists:vehicles,id',
                'activo' => 'required|boolean',
                'fecha' => 'required|date'
            ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'array' => 'El campo :attribute debe ser un arreglo',
            'integer' => 'El campo :attribute debe ser un número',
            'exists' => 'El vehiculo no existe en la base de datos',
            'date' => 'La fecha es inválida',
            'distinct' => 'El id ya está añadido',
            'boolean' => 'El campo debe ser un booleano'
        ];
    }
}
