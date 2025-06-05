<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypesEnum;
use App\Models\Objective;
use App\Models\ObjectiveOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Operation;
use App\Models\OperationPlanned;
use App\Models\OperationUnschedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class OperationController extends Controller
{
    public string $movement_type;

    public function getSixOperationsByAccountId(int $accountId): ?Collection{
        return Operation::getSixOperationsByAccountId($accountId);
    }

    public function thisMonthOperationsByAccountId(int $accountId): ?Collection{
        return Operation::thisMonthOperationsByAccountId($accountId);
    }

    public function getAllIncomesByAccountId(int $accountId): ?Collection{
        return Operation::getAllIncomesByAccountId($accountId);
    }

    public function getAllExpensesByAccountId(int $accountId): ?Collection{
        return Operation::getAllExpensesByAccountId($accountId);
    }

    public function incomeOperations(array $data): JsonResponse{
        $user = Auth::user();
        $accountId = session('active_account_id');

        if (!$accountId) {
            return response()->json(['error' => 'No hay cuenta activa'], 400);
        }

        $offset = $data['offset'];
        $limit = 6;
        $incomes = Operation::getIncomesWithLimitByAccountId($accountId, $offset, $limit);
        if(!$incomes){
            return response()->json(['error' => 'Ha habido un error'], 400);
        }

        return response()->json($incomes);

    }

    public function expenseOperations(array $data): JsonResponse{
        $user = Auth::user();
        $accountId = session('active_account_id');

        if (!$accountId) {
            return response()->json(['error' => 'No hay cuenta activa'], 400);
        }

        $offset = $data['offset'];
        $limit = 6;
        $expenses = Operation::getExpensesWithLimitByAccountId($accountId, $offset, $limit);
        if(!$expenses){
            return response()->json(['error' => 'Ha habido un error'], 400);
        }

        return response()->json($expenses);

    }

    public function saveOperations(array $data): JsonResponse{
        $user = Auth::user();
        $accountId = session('active_account_id');

        if (!$accountId) {
            return response()->json(['error' => 'No hay cuenta activa'], 400);
        }

        $offset = $data['offset'];
        $limit = 6;
        $expenses = Operation::getSaveWithLimitByAccountId($accountId, $offset, $limit);
        if(!$expenses){
            return response()->json(['error' => 'Ha habido un error'], 400);
        }

        return response()->json($expenses);

    }

    public function deleteOperation(int $id): JsonResponse{

        return Operation::deleteOperation($id) ? response()->json(['success' => 'Operación borrada correctamente']) : response()->json(['error' => 'Error al eliminar la operacion. Póngase en contacto con el soporte'], 400);

    }

    public function getOperationById(int $operationId): JsonResponse{
        $operation = Operation::getOperationById($operationId);
        return response()->json([
            'id' => $operation->id,
            'subject' => $operation->subject,
            'description' => $operation->description,
            'amount' => $operation->amount,
            'movement_type_id' => $operation->movement_type_id,
            'action_date' => $operation->action_date,
            'category_id' => $operation->category->id ?? null,
            'category_name' => $operation->category->name ?? null,
            'icon_html' => $operation->category->icon->icon ?? null,

            'is_recurrent' => $operation->planned?->id ? true : false,
            'start_date' => $operation->planned->start_date ?? null,
            'expiration_date' => $operation->planned->expiration_date ?? null,
            'recurrence' => $operation->planned->period ?? null,

            'unscheduled_id' => $operation->unschedule?->id ?? null
        ]);
    }

    public function addOperationRequested(array $data): bool{
        if($this->movement_type == 'income'){
            $data['movement_type_id'] = MovementTypesEnum::INCOME->value;
            $operation = Operation::addOperation($data);
            if($operation){
                if(isset($data['schedule'])){
                    OperationPlanned::addPlannedOperation($operation->id, $data);
                }else{
                    if(!OperationUnschedule::addUnscheduleOperation($operation->id)){
                        return false;
                    }
                }
            }else{
                return false;
            }
        }else{
            if($this->movement_type == 'expense'){
                $data['movement_type_id'] = MovementTypesEnum::EXPENSE->value;
                $operation = Operation::addOperation($data);
                if($operation){
                    if(isset($data['schedule'])){
                        OperationPlanned::addPlannedOperation($operation->id, $data);
                    }else{
                        if(!OperationUnschedule::addUnscheduleOperation($operation->id)){
                            return false;
                        }
                    }
                }
            }else{
                if($this->movement_type == 'save'){
                    $data['movement_type_id'] = MovementTypesEnum::SAVEMONEY->value;
                    $operation = Operation::addOperation($data);
                    if($operation){
                        if(isset($data['schedule'])){
                            if(!OperationPlanned::addPlannedOperation($operation->id, $data)){
                                return false;
                            }
                        }else{
                            if(!OperationUnschedule::addUnscheduleOperation($operation->id)){
                                return false;
                            }
                        }
                        if(isset($data['objectiveId'])){
                            if(!ObjectiveOperation::addObjectiveOperation($data['objectiveId'], $operation->id)){
                                return false;
                            }
                            if(!Objective::updateCurrentAmount($data['objectiveId'], $operation->amount)){
                                return false;
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
}
