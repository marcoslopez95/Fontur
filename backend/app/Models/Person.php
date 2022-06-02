<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class Person extends CrudModel
{
    protected $guarded = ['id'];

    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'correo',
        'municipality_id',
        'cedula',
        'tipo' // V-E-J
    ];

    /**
     * Get the vehicle associated with the Person
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }
}
