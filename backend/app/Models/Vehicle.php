<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class Vehicle extends CrudModel
{
    protected $guarded = ['id'];

    protected $fillable = [
        'person_id',
        'placa',
        'type_fuel',
        'num_controller',
    ];

    /**
     * Get the person that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get all of the supervisions for the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supervisions()
    {
        return $this->hasMany(Supervision::class);
    }

}
