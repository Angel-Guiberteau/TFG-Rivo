<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypesEnum;
use Illuminate\Http\Request;

use App\Models\Operation;
use App\Models\OperationPlanned;
use App\Models\OperationUnschedule;
use Illuminate\Support\Collection;

class OperationController extends Controller
{
    private string $movement_type;
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
    
    public function setOperationType(string $movement_type): bool{
        $this->movement_type = $movement_type;
        return true;
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
                if($this->movement_type == 'saveMoney'){
                    $data['movement_type_id'] = MovementTypesEnum::SAVEMONEY->value;
                }
            }
        }
        return true;
    }
}
