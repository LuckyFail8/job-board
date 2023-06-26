<?php

namespace App\Exceptions;

class ExistingDepartmentCode extends \Exception
{
    protected $message = "Ce code de département existe déjà.";
}
