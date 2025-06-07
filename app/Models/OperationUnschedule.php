<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo OperationUnschedule
 * Representa una operación no recurrente (no planificada).
 */
class OperationUnschedule extends Model
{
    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'operations_unschedule';

    /**
     * Atributos asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'operation_id',
    ];

    /**
     * Añade una operación no planificada (única vez).
     *
     * @param int $operationId ID de la operación a asociar
     * @return bool|self Retorna la instancia si se guarda correctamente, false en caso de fallo
     */
    public static function addUnscheduleOperation(int $operationId): bool | self {
        $operation = new self;

        $operation->operation_id = $operationId;

        if(!$operation->save())
            return false;

        return $operation;
    }
}
