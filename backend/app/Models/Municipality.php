<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'nombre'
    ];
    //protected $with = 'state';

    public function scopeFiltro($query, $request){
        return $query->when($request->nombre,function($q,$nombre){
            return $q->where('nombre','ilike',"%$nombre%");
        })
        ->when($request->state,function($q,$state){
            return $q->whereHas('state', function(Builder $q2) use ($state){
                return $q2->where('nombre','ilike',"%$state%");
            });
        })
        ;
    }

    /**
     * Get the state that owns the Municipality
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get all of the persons for the Municipality
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}
