<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectiveOperation extends Model
{
    protected $table = 'objectives_operations';

    protected $fillable = [
        'objective_id',
        'operation_id',
        'enabled',
    ];

    public static function addObjectiveOperation(int $objectiveId, int $operationId): bool | self{
        $objectiveOperation = new self;

        $objectiveOperation->objective_id = $objectiveId;
        $objectiveOperation->operation_id = $operationId;

        return $objectiveOperation->save() ? $objectiveOperation : false;
    }
}
