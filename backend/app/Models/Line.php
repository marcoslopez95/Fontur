<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;
use Illuminate\Database\Eloquent\Builder;

class Line extends CrudModel
{
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'rif',
        'municipality_id'
    ];

    public function scopeFiltro(Builder $builder, $request){
        return $builder
                ->when($request->name,function(Builder $query,$name){
                    return $query->where('name','ilike',"%$name%");
                })
                ->when($request->rif,function(Builder $query,$rif){
                    return $query->where('rif','ilike',"%$rif%");
                })
                ->when($request->municipality,function(Builder $query,$municipality){
                    return $query->where('municipality',$municipality);
                })
                ;
    }

    /**
     * Get the municipality that owns the Line
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Get all of the vehicles for the Line
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

}
