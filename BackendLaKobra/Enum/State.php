<?php
namespace App\Enum;

enum State : String{
    case PENDIENTE = 'Pendiente';
    case CONFIRMADO = 'Confirmado';
    case CANCELADO = 'Cancelado';
}
?>