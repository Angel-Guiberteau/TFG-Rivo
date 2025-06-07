<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Modelo MovementType que representa los tipos de movimiento (ingreso, gasto, ahorro).
 */
class MovementType extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'movements_types';

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'enabled',
    ];

    /**
     * Obtiene todos los tipos de movimiento habilitados.
     *
     * @return Collection
     */
    public static function getEnabledMovementTypes()
    {
        return self::where('enabled', 1)->get();
    }
}
