<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Modelo Objective que representa los objetivos financieros de los usuarios.
 */
class Objective extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'objectives';

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'target_amount',
        'current_amount',
        'deadline',
        'account_id',
        'enabled',
    ];

    /**
     * Crea un nuevo objetivo.
     *
     * @param array $data
     * @return bool|self
     */
    public static function addObjective(Array $data): bool | self{
        $objective = new self;

        $objective->name = $data['name'];
        $objective->target_amount = $data['target_amount'];
        $objective->current_amount = $data['current_amount'] ?? 0;
        $objective->deadline = $data['deadline'] ?? null;
        $objective->account_id = $data['account_id'];
        $objective->enabled = $data['enabled'] ?? 1;

        return $objective->save() ? $objective : false;
    }

    /**
     * Obtiene todos los objetivos de una cuenta.
     *
     * @param int $accountsId
     * @return Collection
     */
    public static function getObjectives(int $accountsId): Collection{
        return self::where('account_id', $accountsId)->get();
    }

    /**
     * Obtiene un objetivo por su ID.
     *
     * @param int $id
     * @return self|null
     */
    public static function getObjective(int $id): self{
        return self::find($id);
    }

    /**
     * Obtiene todos los objetivos activos por ID de cuenta.
     *
     * @param int $accountsId
     * @return Collection
     */
    public static function getObjectivesByAccountId(int $accountsId): Collection{
        return self::where('account_id', $accountsId)
            ->where('enabled', 1)
            ->get();
    }

    /**
     * Elimina un objetivo por su ID.
     *
     * @param int $objectiveId
     * @return bool
     */
    public static function deleteObjective(int $objectiveId): bool {
        $objective = self::find($objectiveId);
        if (!$objective) return false;

        return $objective->delete();
    }

    /**
     * Actualiza parcialmente un objetivo.
     *
     * @param array $data
     * @return bool
     */
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

    /**
     * Actualiza todos los campos de un objetivo.
     *
     * @param array $data
     * @return bool
     */
    public static function updateFullObjective(array $data): bool{
        $objective = self::find($data['id']);
        if (!$objective) return false;

        $objective->name = $data['name'];
        $objective->target_amount = $data['target_amount'];
        $objective->current_amount = $data['current_amount'];
        if (!empty($data['deadline'])) {
            $objective->deadline = $data['deadline'];
        }
        $objective->account_id = $data['account_id'];
        $objective->enabled = $data['enabled'] ?? 1;

        return $objective->save();
    }

    /**
     * Actualiza el valor actual del objetivo según el monto de una operación.
     *
     * @param int $objectiveId
     * @param float $operationAmount
     * @param bool $negative
     * @return bool
     */
    public static function updateCurrentAmount(int $objectiveId, float $operationAmount, bool $negative = false): bool{
        $objective = self::find($objectiveId);
        if(!$negative)
            $objective->current_amount += $operationAmount;
        else
            $objective->current_amount -= $operationAmount;

        return $objective->save();
    }
}
