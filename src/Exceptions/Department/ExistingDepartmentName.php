<?php

namespace App\Exceptions;

class ExistingDepartmentName extends \Exception
{
    protected $message = "Ce nom de département existe déjà.";
}
