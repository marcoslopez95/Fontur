<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Line;

use App\Core\CrudRepository;
use App\Models\Line;
use App\Models\Municipality;
use Illuminate\Http\Request;

/** @property Line $model */
class LineRepository extends CrudRepository
{

    public function __construct(Line $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $lines = $this->model::Filtro($request)
        ->addSelect([
            'municipality' => Municipality::select('nombre')->whereColumn('municipalities.id','municipality_id')->limit(1)
        ])
        ->orderBy('name','asc')
        ->get();

        return $lines;
    }

    public function show($id)
    {
        $line = $this->model::addSelect([
            'municipality' => Municipality::select('nombre')->whereColumn('municipalities.id','municipality_id')->limit(1)
        ])
        ->find($id);

        return $line;
    }

}
