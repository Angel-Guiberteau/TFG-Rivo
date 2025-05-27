<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationPlanned extends Model
{
    protected $table = 'operations_planned';

    protected $fillable = [
        'operation_id',
        'start_date',
        'expiration_date',
        'period',
        'enabled',
    ];

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
