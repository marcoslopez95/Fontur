<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Supervision;

use App\Core\CrudRepository;
use App\Models\Supervision;

/** @property Supervision $model */
class SupervisionRepository extends CrudRepository
{

    public function __construct(Supervision $model)
    {
        parent::__construct($model);
    }

}