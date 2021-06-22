<?php

namespace App\Helpers\Rules;

use App\Models\Modelos\JuntasDirectivas;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    use Respect\Validation\Rules\AbstractRule;

Class ResponsableDisponible extends AbstractRule
{
    public function validate($input, array $extraParams = [])
    {

        $params = array_merge(
            get_class_vars(__CLASS__),
            get_object_vars($this),
            $extraParams,
            compact('input')
        );

        var_dump( $params );
        die();


       // return JuntasDirectivas::where('cod_org', $input)->where('dni', $params)->count() === 0;
    }

}


