<?php

namespace src\Library\Fechas;

class CalcularFechas {

    public static function calcularProximoMes($fecha = null) {
        $fecha = $fecha ? $fecha : date('Y-m-d');
        $sumar_mes = strtotime('+1 month', strtotime($fecha));
        return date('Y-m-d', $sumar_mes);
    }

}
