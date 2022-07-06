<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\Supervisor;


use App\Core\CrudService;
use App\Repositories\Supervisor\SupervisorRepository;

/** @property SupervisorRepository $repository */
class SupervisorService extends CrudService
{

    protected $name = "supervisor";
    protected $namePlural = "supervisors";

    public function __construct(SupervisorRepository $repository)
    {
        parent::__construct($repository);
    }

}