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
}
