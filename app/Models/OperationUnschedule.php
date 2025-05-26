<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationUnschedule extends Model
{
    protected $table = 'operations_unschedule';

    protected $fillable = [
        'operation_id',
    ];

    public static function addUnscheduleOperation(int $operationId): bool | self {
        $operation = new self;

        $operation->operation_id = $operationId;
        
        if(!$operation->save())
            return false;

        return $operation;
    }
}
