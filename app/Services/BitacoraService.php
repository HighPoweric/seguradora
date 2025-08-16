<?php
namespace App\Services;

use App\Models\Bitacora;

class BitacoraService
{
    //funcion para registrar eventos en la Bitacora

    public static function registrarEvento($evento, $descripcion = null, $usuarioId = 0)
    {
        /**
         * @param string $evento [nombre de la funcion]
         * @param string|null $descripcion [descripcion del evento]
         * @param int $usuarioId [userID o 0 si es Sistema]
         */
        $bitacora = new Bitacora();
        $bitacora->evento = $evento;
        $bitacora->descripcion = $descripcion;
        $bitacora->usuario_id = $usuarioId; // Asignar el ID del usuario que realiza la acción
        $bitacora->save();
    }
}