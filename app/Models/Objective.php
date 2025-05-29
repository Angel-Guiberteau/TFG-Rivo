<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Objective extends Model
{
    protected $table = 'objectives';

    protected $fillable = [
        'name',
        'target_amount',
        'current_amount',
        'deadline',
        'account_id',
        'enabled',
    ];

    public static function addObjective(Array $data): bool | self{
        $objective = new self;

        $objective->name = $data['name'];
        $objective->target_amount = $data['target_amount'];
        $objective->current_amount = $data['current_amount'];
        $objective->deadline = $data['deadline'];
        $objective->account_id = $data['account_id'];

        return $objective->save() ? $objective : false;

    }

    public static function getObjectives(): Collection{
        return self::where('enabled', 1)
            ->get();
    }
    
    public static function getObjectivesByAccountId(int $accountsId): Collection{
        return self::where('account_id', $accountsId)
            ->where('enabled', 1)
            ->get();
    }
}
