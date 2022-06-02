<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class Supervision extends CrudModel
{
    protected $guarded = ['id'];
    protected $fillable = [
        'vehicle_id',
        'fecha',
        'activo'
    ];

    protected $with = 'vehicle.person.municipality';
    /**
     * Get the vehicle that owns the Supervision
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
