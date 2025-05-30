<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Operation extends Model
{
    protected $table = 'operations';

    protected $fillable = [
        'subject',
        'description',
        'amount',
        'movement_type_id',
        'action_date',
        'account_id',
        'category_id',
        'enabled',
    ];

    public static function addOperation(Array $data): bool | self {
        $operation = new self;

        $operation->subject = $data['subject'];
        $operation->description = $data['description'];
        $operation->amount = $data['amount'];
        $operation->action_date = $data['action_date'];
        $operation->account_id = $data['account_id'];
        $operation->movement_type_id = $data['movement_type_id'];
        $operation->category_id = 1;
        
        if(!$operation->save())
            return false;

        return $operation;
    }
    
    public static function getAllOperationsByAccountId(int $acocuntId): ?Collection {
        return self::where('account_id', $acocuntId)
            ->get();
    }
}
