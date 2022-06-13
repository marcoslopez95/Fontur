<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supervision extends CrudModel
{

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = [
        'vehicle_id',
        'fecha',
        'activo'
    ];

    public function getFechaAttribute($value){
        return  Carbon::parse($value)->format('Y-m-d');
    }

    public function getActivoAttribute($value){
        return
            $value == true ?
            'Sí':
            'No';
    }
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
