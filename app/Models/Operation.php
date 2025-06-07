<?php

namespace App\Models;

use App\Enums\MovementTypesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Modelo Operation
 * Representa una operación financiera realizada en una cuenta.
 */
class Operation extends Model
{
    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'operations';

    /**
     * Atributos asignables en masa.
     *
     * @var array<int, string>
     */
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

    /**
     * Crea una nueva operación.
     *
     * @param array $data
     * @return bool|self
     */
    public static function addOperation(Array $data): bool | self {
        $operation = new self;

        $operation->subject = $data['subject'];
        $operation->description = $data['description'];
        $operation->amount = $data['amount'];
        $operation->action_date = $data['action_date'];
        $operation->account_id = $data['account_id'];
        $operation->movement_type_id = $data['movement_type_id'];
        $operation->category_id = $data['category_id'];

        if(!$operation->save())
            return false;

        return $operation;
    }

    /**
     * Obtiene todas las operaciones de una cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public static function getAllOperationsByAccountId(int $accountId): ?Collection {
        return self::where('account_id', $accountId)
            ->get();
    }

    /**
     * Obtiene las operaciones del mes actual agrupadas por categoría y tipo de movimiento.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public static function thisMonthOperationsByAccountId(int $accountId): ?Collection {
        $operations = self::with('category.icon')
            ->where('account_id', $accountId)
            ->whereMonth('action_date', Carbon::now()->month)
            ->whereYear('action_date', Carbon::now()->year)
            ->get();

        return $operations->groupBy(function ($item) {
            return $item->category_id . '-' . $item->movement_type_id;
        })->map(function ($items) {
            return [
                'category_id' => $items->first()->category_id,
                'category_name' => $items->first()->category->name ?? 'Sin categoría',
                'icon' => $items->first()->category->icon->icon ?? 'fas fa-question-circle',
                'movement_type_id' => $items->first()->movement_type_id,
                'total_amount' => $items->sum('amount'),
            ];
        })->values();
    }

    /**
     * Obtiene las últimas seis operaciones de una cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public static function getSixOperationsByAccountId(int $accountId): ?Collection {
        return self::with('category.icon')
            ->where('account_id', $accountId)
            ->orderByDesc('action_date')
            ->take(6)
            ->get();
    }

    /**
     * Obtiene todos los ingresos de una cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public static function getAllIncomesByAccountId(int $accountId): ?Collection {
        return self::with('category.icon')
            ->where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::INCOME->value)
            ->orderByDesc('action_date')
            ->get();
    }

    /**
     * Obtiene una operación por su ID.
     *
     * @param int $operationId
     * @return self|null
     */
    public static function getOperationById(int $operationId): ?self {
        return Operation::with(['category.icon', 'planned', 'unschedule'])
            ->findOrFail($operationId);
    }

    /**
     * Obtiene todos los egresos de una cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public static function getAllExpensesByAccountId(int $accountId): ?Collection {
        return self::with('category.icon')
            ->where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::EXPENSE->value)
            ->orderByDesc('action_date')
            ->get();
    }

    /**
     * Obtiene ingresos paginados.
     *
     * @param int $accountId
     * @param int $offset
     * @param int $limit
     * @return Collection|null
     */
    public static function getIncomesWithLimitByAccountId(int $accountId, int $offset,int $limit): ?Collection {
        return self::where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::INCOME->value)
            ->with('category.icon')
            ->orderBy('action_date', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    /**
     * Obtiene egresos paginados.
     *
     * @param int $accountId
     * @param int $offset
     * @param int $limit
     * @return Collection|null
     */
    public static function getExpensesWithLimitByAccountId(int $accountId, int $offset,int $limit): ?Collection {
        return self::where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::EXPENSE->value)
            ->with('category.icon')
            ->orderBy('action_date', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    /**
     * Obtiene ahorros paginados.
     *
     * @param int $accountId
     * @param int $offset
     * @param int $limit
     * @return Collection|null
     */
    public static function getSaveWithLimitByAccountId(int $accountId, int $offset,int $limit): ?Collection {
        return self::where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::SAVEMONEY->value)
            ->with('category.icon')
            ->orderBy('action_date', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    /**
     * Obtiene todas las operaciones paginadas.
     *
     * @param int $accountId
     * @param int $offset
     * @param int $limit
     * @return Collection|null
     */
    public static function getAllOperationsWithLimitByAccountId(int $accountId, int $offset,int $limit): ?Collection {
        return self::where('account_id', $accountId)
            ->with('category.icon')
            ->orderBy('action_date', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    /**
     * Elimina una operación y sus relaciones (planeada o no planeada).
     *
     * @param int $id
     * @return bool
     */
    public static function deleteOperation(int $id): bool {
        DB::beginTransaction();
        try {
            $operation = self::findOrFail($id);

            if ($operation->planned) {
                $operation->planned->delete();
            }

            if ($operation->unscheduled) {
                $operation->unscheduled->delete();
            }

            $operation->delete();

            DB::commit();
            return true;

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar operación $id: " . $e->getMessage());
            return false;
        }

    }

    /**
     * Relación con la categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación con la operación planeada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function planned()
    {
        return $this->hasOne(OperationPlanned::class);
    }

    /**
     * Relación con la operación no planeada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function unschedule()
    {
        return $this->hasOne(OperationUnschedule::class);
    }
}
