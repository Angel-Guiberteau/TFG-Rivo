<?php

namespace App\Models;

use App\Enums\MovementTypesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $operation->category_id = $data['category_id'];

        if(!$operation->save())
            return false;
        
        return $operation;
    }
    
    public static function getAllOperationsByAccountId(int $accountId): ?Collection {
        return self::where('account_id', $accountId)
            ->get();
    }
    
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

    
    public static function getSixOperationsByAccountId(int $accountId): ?Collection{
        
        return self::with('category.icon')
            ->where('account_id', $accountId)
            ->orderByDesc('action_date')
            ->take(6)
            ->get();
    }

    public static function getAllIncomesByAccountId(int $accountId): ?Collection{
        return self::with('category.icon')
            ->where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::INCOME->value)
            ->orderByDesc('action_date')
            ->get();
    }
    
    public static function getOperationById(int $operationId): ?self{
        return Operation::with(['category.icon', 'planned', 'unschedule'])
            ->findOrFail($operationId);
    }
    
    public static function getAllExpensesByAccountId(int $accountId): ?Collection{
        return self::with('category.icon')
            ->where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::EXPENSE->value)
            ->orderByDesc('action_date')
            ->get();
    }
    
    public static function getIncomesWithLimitByAccountId(int $accountId, int $offset,int $limit): ?Collection{
        return self::where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::INCOME->value)
            ->with('category.icon')
            ->orderBy('action_date', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public static function getExpensesWithLimitByAccountId(int $accountId, int $offset,int $limit): ?Collection{
        return self::where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::EXPENSE->value)
            ->with('category.icon')
            ->orderBy('action_date', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }
    
    public static function getSaveWithLimitByAccountId(int $accountId, int $offset,int $limit): ?Collection{
        return self::where('account_id', $accountId)
            ->where('movement_type_id', MovementTypesEnum::SAVEMONEY->value)
            ->with('category.icon')
            ->orderBy('action_date', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }
    
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
        
        return true;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function planned()
    {
        return $this->hasOne(OperationPlanned::class);
    }

    public function unschedule()
    {
        return $this->hasOne(OperationUnschedule::class);
    }

}
