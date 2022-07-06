<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\Line;


use App\Core\CrudService;
use App\Repositories\Line\LineRepository;

/** @property LineRepository $repository */
class LineService extends CrudService
{

    protected $name = "line";
    protected $namePlural = "lines";

    public function __construct(LineRepository $repository)
    {
        parent::__construct($repository);
    }

}