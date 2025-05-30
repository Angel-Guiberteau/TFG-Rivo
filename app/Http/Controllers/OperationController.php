<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Operation;
use Illuminate\Support\Collection;

class OperationController extends Controller
{
    public function getSixOperationsByAccountId(int $accountId): ?Collection{
        return Operation::getSixOperationsByAccountId($accountId);
    }
    
    public function thisMonthOperationsByAccountId(int $accountId): ?Collection{
        return Operation::thisMonthOperationsByAccountId($accountId);
    }
}
