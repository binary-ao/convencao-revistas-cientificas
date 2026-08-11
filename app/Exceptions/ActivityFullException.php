<?php

namespace App\Exceptions;

use RuntimeException;

class ActivityFullException extends RuntimeException
{
    public function __construct(string $activityName)
    {
        parent::__construct("A actividade \"{$activityName}\" já não tem vagas disponíveis.");
    }
}
