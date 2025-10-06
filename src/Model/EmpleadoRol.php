<?php

namespace App\Model;
use App\ORM\BaseModel;

class EmpleadoRol extends BaseModel
{
    protected $table = 'empleados_roles';
    protected ?string $primary = null;
}