<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;
use Illuminate\Database\Eloquent\Builder;

class Supervisor extends CrudModel
{
    protected $guarded = ['id'];
    protected $fillable = [
        'first_name',
        'last_name',
        'ci',
        'regional',
        'municipality_id'
    ];

    public function getRegionalAttribute($value){
        return $value ? 'Sí' : 'No';
    }
    public function scopeFiltro(Builder $builder, $request){
        return $builder
                ->when($request->first_name,function(Builder $query, $first_name){
                    return $query->where('first_name','ilike',"%$first_name%");
                })
                ->when($request->last_name,function(Builder $query, $last_name){
                    return $query->where('last_name','ilike',"%$last_name%");
                })
                ->when($request->ci,function(Builder $query, $ci){
                    return $query->where('ci','ilike',"%$ci%");
                })
                ->when($request->regional,function(Builder $query, $regional){
                    return $query->where('regional',$regional);
                })
                ->when($request->municipality_id,function(Builder $query, $municipality_id){
                    return $query->where('municipality_id',$municipality_id);
                });
    }

    public function scopeRegional(Builder $query){
        return $query->where('regional',true);
    }

    /**
     * Get the municipality that owns the Supervisor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Get all of the Supervision for the Supervisor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supervision()
    {
        return $this->hasMany(Supervision::class);
    }
}
