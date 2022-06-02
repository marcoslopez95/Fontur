<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class Vehicle extends CrudModel
{
    protected $guarded = ['id'];

    protected $fillable = [
        'placa',
        'person_id'
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
}
