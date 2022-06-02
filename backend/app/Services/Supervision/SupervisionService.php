<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\Supervision;


use App\Core\CrudService;
use App\Repositories\Supervision\SupervisionRepository;

/** @property SupervisionRepository $repository */
class SupervisionService extends CrudService
{

    protected $name = "supervision";
    protected $namePlural = "supervisions";

    public function __construct(SupervisionRepository $repository)
    {
        parent::__construct($repository);
    }

}