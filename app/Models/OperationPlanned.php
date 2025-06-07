<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo OperationPlanned
 * Representa una operación planificada asociada a una operación principal.
 */
class OperationPlanned extends Model
{
    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'operations_planned';

    /**
     * Atributos asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'operation_id',
        'start_date',
        'expiration_date',
        'period',
        'enabled',
    ];

    /**
     * Añade una nueva operación planificada.
     *
     * @param int $operationId ID de la operación principal
     * @param array $data Datos de configuración de la operación planificada
     * @return bool|self Retorna la instancia si se guarda correctamente, false en caso de error
     */
    public static function addPlannedOperation(int $operationId, Array $data): bool | self {
        $operation = new self;

        $operation->operation_id = $operationId;
        $operation->start_date = $data['start_date'];
        $operation->period = $data['period'];

        if(!$operation->save())
            return false;

        return $operation;
    }
}
