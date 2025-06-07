<?php

namespace App\Enums;

/**
 * Enum MovementTypesEnum
 *
 * Define los tipos de movimiento posibles en el sistema.
 *
 * - INCOME: Representa un ingreso.
 * - EXPENSE: Representa un gasto.
 * - SAVEMONEY: Representa un ahorro.
 */
enum MovementTypesEnum: string
{
    /** Ingreso */
    case INCOME = '1';

    /** Gasto */
    case EXPENSE = '2';

    /** Ahorro */
    case SAVEMONEY = '3';
}
