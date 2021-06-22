<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model {

    protected $table = 'documento_pago';
    protected $fillable = [
        'id_documentopago',
        'id_vendedor',
        'id_pedido',
        'total',
        'fecha',
        'id_tipodocumento',
    ];

}
