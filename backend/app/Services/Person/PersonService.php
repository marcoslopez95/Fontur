<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\Person;


use App\Core\CrudService;
use App\Repositories\Person\PersonRepository;

/** @property PersonRepository $repository */
class PersonService extends CrudService
{

    protected $name = "person";
    protected $namePlural = "people";

    public function __construct(PersonRepository $repository)
    {
        parent::__construct($repository);
    }

}