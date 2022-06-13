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
                //
                'person_id' => 'nullable',
                'placa' => 'string|unique:vehicles',
                'type_fuel' => ['string', Rule::in(['Gasolina','Diesel','Eléctrico'])],
                'num_controller'    => 'string',
            ];
        }
        if($this->isMethod('put')){
            return [
                //
                'person_id' => 'nullable',
                'placa' => ['string',Rule::unique('vehicles')->ignore($this->vehicle)],
                'type_fuel' => ['string', Rule::in(['Gasolina','Diesel','Eléctrico'])],
                'num_controller'    => 'string',
            ];
        }

    }
}
