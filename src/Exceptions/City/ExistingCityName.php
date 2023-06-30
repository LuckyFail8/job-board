<?php

namespace App\Exceptions;

class ExistingCityName extends \Exception
{
    protected $message = "Cette ville existe déjà.";
}
