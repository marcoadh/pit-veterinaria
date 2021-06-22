<?php

namespace App\Helpers\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class ResponsableDisponibleException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'El DNI del responsable ya se encuentra registrado en nuestro sistema.',
        ],
    ];
}
