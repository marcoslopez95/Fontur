<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'nombre'
    ];


    public function scopeFiltro($query, $request){
        return $query->when($request->name,function($q,$name){
            return $q->where('nombre','ilike',"%$name%");
        });
    }

    /**
     * Get all of the municipalities for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}
