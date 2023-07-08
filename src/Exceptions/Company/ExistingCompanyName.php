<?php

namespace App\Exceptions;

class ExistingCompanyName extends \Exception
{
    protected $message = "Cette compagnie existe déjà.";
}
