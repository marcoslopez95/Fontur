<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supervision extends CrudModel
{

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = [
        'vehicle_id',
        'fecha',
        'supervisor_id',
        'municipality_id'
    ];

    /**
     * Get the supervisor that owns the Supervision
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function getFechaAttribute($value)
    {
        return  Carbon::parse($value)->format('Y-m-d');
    }

    public function getActivoAttribute($value)
    {
        return
            $value == true ?
            'Sí' :
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

    public function scopeFiltro($query, $request)
    {
        return $query->when($request->fecha_fin && $request->fecha_ini, function ($q2) use ($request) {
            $start = Carbon::parse($request->fecha_ini)->startOfDay();
            $end = Carbon::parse($request->fecha_fin)->endOfDay();
            $rango = [$start,$end];
            //dd($rango);
            $q2->whereBetween('fecha', $rango);
        })
        ->when($request->placa,function($q,$placa){
            $q->whereHas('vehicle', function (Builder $query) use ($placa){
                $query->where('placa','ilike',"%$placa%");
            });
        })
        ->when($request->line,function($q,$line){
            $q->whereHas('vehicle', function(Builder $query) use ($line){
                $query->where('line_id',$line);
            });
        })
        ->when($request->type_fuel,function($q,$type_fuel){
            $q->whereHas('vehicle', function (Builder $query) use ($type_fuel){
                $query->where('placa','ilike',"%$type_fuel%");
            });
        })
        ->when($request->num_controller,function($q,$num_controller){
            $q->whereHas('vehicle', function (Builder $query) use ($num_controller){
                $query->where('placa','ilike',"%$num_controller%");
            });
        })
        ->when($request->supervisor_id,function(Builder $q,$id){
            return $q->where('supervisor_id',$id);
        })
        ->when($request->municipality_id,function($q,$municipality_id){
            $q->whereHas('vehicle', function (Builder $query) use ($municipality_id){
                $query->whereHas('line', function (Builder $query) use ($municipality_id){
                    $query->where('municipality_id',$municipality_id);
                });
            });
        });
    }
}
