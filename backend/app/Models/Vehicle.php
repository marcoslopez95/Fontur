<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends CrudModel
{

    use SoftDeletes;

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

    public function scopeFiltro($query,$request){
        return $query
        ->when($request->placa, function ($query2,$placa){
            return $query2->where('placa','ilike',"%$placa%");
        })
        ->when($request->type_fuel, function ($query2,$type_fuel){
            return $query2->where('type_fuel','ilike',"%$type_fuel%");
        })
        ->when($request->num_controller, function ($query2,$num_controller){
            return $query2->where('num_controller','ilike',"%$num_controller%");
        })
        ->when($request->fecha_ini&&$request->fecha_fin,function($q) use ($request){
            $q->whereHas('supervisions', function (Builder $query) use($request){
                $rango = [$request->fecha_ini, $request->fecha_fin];
                //dd($rango);
                $query->whereBetween('fecha', $rango);
            });
        })
        ;

    }

}
