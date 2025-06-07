<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * Modelo ObjectiveOperation
 * Relaciona operaciones con objetivos de ahorro.
 */
class ObjectiveOperation extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'objectives_operations';

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'objective_id',
        'operation_id',
        'enabled',
    ];

    /**
     * Obtiene una relación objetivo-operación por el ID de operación.
     *
     * @param int $operationId
     * @return ObjectiveOperation|null
     */
    public static function getObjectiveOperationByOperationId(int $operationId): ?ObjectiveOperation {
        return self::where('operation_id', $operationId)
            ->first();
    }

    /**
     * Crea una nueva relación entre un objetivo y una operación.
     *
     * @param int $objectiveId
     * @param int $operationId
     * @return bool|self
     */
    public static function addObjectiveOperation(int $objectiveId, int $operationId): bool | self{
        $objectiveOperation = new self;

        $objectiveOperation->objective_id = $objectiveId;
        $objectiveOperation->operation_id = $operationId;

        return $objectiveOperation->save() ? $objectiveOperation : false;
    }
}
