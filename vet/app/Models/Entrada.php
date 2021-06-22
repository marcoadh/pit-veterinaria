<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'tb_entrada';

    protected $fillable = [
        'codigo',
        'categoria',
        'principal',
        'titulo',
        'detalle',
        'detallecorto',
        'foto',
        'estado',
        'fecha',
    ];
    
    public function getDateSpanishAttribute() {
        $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
        $fecha = Carbon::parse($this->fecha);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }   
}
