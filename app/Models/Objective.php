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
        $objective->current_amount = $data['current_amount'] ?? 0;
        $objective->deadline = $data['deadline'] ?? null;
        $objective->account_id = $data['account_id'];

        return $objective->save() ? $objective : false;

    }

    public static function getObjectives(): Collection{
        return self::where('enabled', 1)
            ->get();
    }

    public static function getObjective(int $id): self{
        return self::find($id);
    }

    public static function getObjectivesByAccountId(int $accountsId): Collection{
        return self::where('account_id', $accountsId)
            ->where('enabled', 1)
            ->get();
    }

    public static function deleteObjective(int $objectiveId): bool {
        $objective = self::find($objectiveId);
        if (!$objective) return false;

        return $objective->delete();
    }


    public static function updateObjective(array $data): bool{
        $objective = self::find($data['objective_id']);
        if (!$objective) return false;

        $objective->name = $data['name'];
        $objective->target_amount = $data['target_amount'];

        if (isset($data['current_amount'])) {
            $objective->current_amount = $data['current_amount'];
        }
        if (isset($data['deadline'])) {
            $objective->deadline = $data['deadline'];
        }

        return $objective->save();
    }

    public static function updateCurrentAmount(int $objectiveId, float $operationAmount, bool $negative = false): bool{
        $objective = self::find($objectiveId);
        if(!$negative)
            $objective->current_amount += $operationAmount;
        else
            $objective->current_amount -= $operationAmount;

        return $objective->save();
    }
}
