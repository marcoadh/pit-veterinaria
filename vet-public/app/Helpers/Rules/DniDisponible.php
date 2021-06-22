<?php

namespace App\Helpers\Rules;

use App\Models\Modelos\Usuarios;
use Respect\Validation\Rules\AbstractRule;

Class DniDisponible extends AbstractRule
{
    public function validate($input)
    {
        return Usuarios::where('dni', $input)->count() === 0;
    }

}
