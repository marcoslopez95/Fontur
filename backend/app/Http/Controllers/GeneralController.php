<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    //

    public function getMunicipalities(Request $request){
        return Municipality::filtro($request)->get();
    }
}
