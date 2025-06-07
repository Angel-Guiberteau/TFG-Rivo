<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypesEnum;
use App\Models\Account;
use App\Models\Objective;
use App\Models\ObjectiveOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Operation;
use App\Models\OperationPlanned;
use App\Models\OperationUnschedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Controlador OperationController
 *
 * Gestiona las operaciones de tipo ingreso, gasto o ahorro, tanto programadas como no programadas.
 */
class OperationController extends Controller
{
    /** @var string $movement_type Tipo de movimiento actual (income, expense, save) */
    public string $movement_type;

    /**
     * Obtiene las 6 operaciones más recientes por cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public function getSixOperationsByAccountId(int $accountId): ?Collection {
        return Operation::getSixOperationsByAccountId($accountId);
    }

    /**
     * Obtiene todas las operaciones del mes actual por cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public function thisMonthOperationsByAccountId(int $accountId): ?Collection {
        return Operation::thisMonthOperationsByAccountId($accountId);
    }

    /**
     * Devuelve todos los ingresos de una cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public function getAllIncomesByAccountId(int $accountId): ?Collection {
        return Operation::getAllIncomesByAccountId($accountId);
    }

    /**
     * Devuelve todos los gastos de una cuenta.
     *
     * @param int $accountId
     * @return Collection|null
     */
    public function getAllExpensesByAccountId(int $accountId): ?Collection {
        return Operation::getAllExpensesByAccountId($accountId);
    }

    /**
     * Devuelve ingresos con paginación.
     *
     * @param array $data Datos con offset.
     * @return JsonResponse
     */
    public function incomeOperations(array $data): JsonResponse {
        $accountId = session('active_account_id');
        if (!$accountId) return response()->json(['error' => 'No hay cuenta activa'], 400);

        $offset = $data['offset'];
        $limit = 6;
        $incomes = Operation::getIncomesWithLimitByAccountId($accountId, $offset, $limit);
        return $incomes ? response()->json($incomes) : response()->json(['error' => 'Ha habido un error'], 400);
    }

    /**
     * Devuelve gastos con paginación.
     *
     * @param array $data Datos con offset.
     * @return JsonResponse
     */
    public function expenseOperations(array $data): JsonResponse {
        $accountId = session('active_account_id');
        if (!$accountId) return response()->json(['error' => 'No hay cuenta activa'], 400);

        $offset = $data['offset'];
        $limit = 6;
        $expenses = Operation::getExpensesWithLimitByAccountId($accountId, $offset, $limit);
        return $expenses ? response()->json($expenses) : response()->json(['error' => 'Ha habido un error'], 400);
    }

    /**
     * Devuelve ahorros con paginación.
     *
     * @param array $data Datos con offset.
     * @return JsonResponse
     */
    public function saveOperations(array $data): JsonResponse {
        $accountId = session('active_account_id');
        if (!$accountId) return response()->json(['error' => 'No hay cuenta activa'], 400);

        $offset = $data['offset'];
        $limit = 6;
        $expenses = Operation::getSaveWithLimitByAccountId($accountId, $offset, $limit);
        return $expenses ? response()->json($expenses) : response()->json(['error' => 'Ha habido un error'], 400);
    }

    /**
     * Devuelve operaciones paginadas por cuenta.
     *
     * @param array $data Datos con offset y límite.
     * @return JsonResponse
     */
    public function getAllOperationsWithLimitByAccountId(array $data): JsonResponse {
        $accountId = session('active_account_id');
        if (!$accountId) return response()->json(['error' => 'No hay cuenta activa'], 400);

        $offset = $data['offset'] ?? 0;
        $limit  = $data['limit'] ?? 20;

        $operations = Operation::getAllOperationsWithLimitByAccountId($accountId, $offset, $limit);
        return response()->json($operations);
    }

    /**
     * Elimina una operación por ID y actualiza las entidades relacionadas.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteOperation(int $id): JsonResponse {
        DB::beginTransaction();
        $operation = Operation::getOperationById($id);
        if (!$operation) {
            DB::rollBack();
            return response()->json(['error' => 'Operación no encontrada'], 404);
        }

        // Reversión de operaciones según tipo
        if ($operation->movement_type_id == MovementTypesEnum::SAVEMONEY->value) {
            $objectiveOperation = ObjectiveOperation::getObjectiveOperationByOperationId($id);
            if ($objectiveOperation) {
                $objective = Objective::getObjective($objectiveOperation->objective_id);
                if ($objective && !Objective::updateCurrentAmount($objective->id, $operation->amount, true)) {
                    DB::rollBack();
                    return response()->json(['error' => 'Error al actualizar el objetivo'], 400);
                }
            }

            $accountId = session('active_account_id');
            if (!$accountId || !Account::updateSaveToTotalSave($accountId, $operation->amount, true)) {
                DB::rollBack();
                return response()->json(['error' => 'Error al actualizar el total ahorrado'], 400);
            }
        } elseif ($operation->movement_type_id == MovementTypesEnum::INCOME->value) {
            if (!Account::updateAccountBalance($operation->account_id, $operation->amount, true)) {
                DB::rollBack();
                return response()->json(['error' => 'Error al actualizar el balance de la cuenta'], 400);
            }
        } elseif ($operation->movement_type_id == MovementTypesEnum::EXPENSE->value) {
            if (!Account::addIncomeToBalance($operation->account_id, $operation->amount)) {
                DB::rollBack();
                return response()->json(['error' => 'Error al actualizar el balance de la cuenta'], 400);
            }
        }

        DB::commit();
        return Operation::deleteOperation($id)
            ? response()->json(['success' => 'Operación borrada correctamente'])
            : response()->json(['error' => 'Error al eliminar la operacion. Póngase en contacto con el soporte'], 400);
    }

    /**
     * Devuelve una operación por su ID.
     *
     * @param int $operationId
     * @return JsonResponse
     */
    public function getOperationById(int $operationId): JsonResponse {
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

    /**
     * Añade una operación solicitada según el tipo (ingreso, gasto o ahorro).
     *
     * @param array $data Datos de la operación.
     * @return bool True si se añadió correctamente, false en caso de error.
     */
    public function addOperationRequested(array $data): bool {
        if ($this->movement_type == 'income') {
            $data['movement_type_id'] = MovementTypesEnum::INCOME->value;
            $operation = Operation::addOperation($data);
            if ($operation) {
                if (!Account::addIncomeToBalance($operation->account_id, $operation->amount)) return false;
                return isset($data['schedule'])
                    ? OperationPlanned::addPlannedOperation($operation->id, $data)
                    : OperationUnschedule::addUnscheduleOperation($operation->id);
            }
            return false;
        }

        if ($this->movement_type == 'expense') {
            $data['movement_type_id'] = MovementTypesEnum::EXPENSE->value;
            $operation = Operation::addOperation($data);
            if ($operation) {
                if (!Account::addExpenseToBalance($operation->account_id, $operation->amount)) return false;
                return isset($data['schedule'])
                    ? OperationPlanned::addPlannedOperation($operation->id, $data)
                    : OperationUnschedule::addUnscheduleOperation($operation->id);
            }
            return false;
        }

        if ($this->movement_type == 'save') {
            $data['movement_type_id'] = MovementTypesEnum::SAVEMONEY->value;
            $operation = Operation::addOperation($data);
            if ($operation) {
                if (!Account::addSaveToTotalSave($operation->account_id, $operation->amount)) return false;

                if (isset($data['schedule'])) {
                    if (!OperationPlanned::addPlannedOperation($operation->id, $data)) return false;
                } else {
                    if (!OperationUnschedule::addUnscheduleOperation($operation->id)) return false;
                }

                if (isset($data['objectiveId'])) {
                    if (!ObjectiveOperation::addObjectiveOperation($data['objectiveId'], $operation->id)) return false;
                    if (!Objective::updateCurrentAmount($data['objectiveId'], $operation->amount)) return false;
                }
                return true;
            }
        }

        return false;
    }
}
