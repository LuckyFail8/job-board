<?php

namespace App\Exceptions;

class ExistingPlatformName extends \Exception
{
    protected $message = "Cette plateforme existe déjà.";
}
