<?php

namespace App\Helpers\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class DniDisponibleException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'El DNI ya se encuentra registrado en nuestro sistema.',
        ],
    ];
}
