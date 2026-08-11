<?php

namespace App\Exceptions;

use App\Models\Registration;
use RuntimeException;

class DuplicateRegistrationException extends RuntimeException
{
    public function __construct(public readonly Registration $existingRegistration)
    {
        parent::__construct('Já existe uma inscrição associada a este endereço de email.');
    }
}
