<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Object_;

class ObjectiveOperation extends Model
{
    protected $table = 'objectives_operations';

    protected $fillable = [
        'objective_id',
        'operation_id',
        'enabled',
    ];

    public static function getObjectiveOperationByOperationId(int $operationId): ?ObjectiveOperation {
        return self::where('operation_id', $operationId)
            ->first();
    }

    public static function addObjectiveOperation(int $objectiveId, int $operationId): bool | self{
        $objectiveOperation = new self;

        $objectiveOperation->objective_id = $objectiveId;
        $objectiveOperation->operation_id = $operationId;

        return $objectiveOperation->save() ? $objectiveOperation : false;
    }
}
