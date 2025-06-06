<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Account;
use Illuminate\Validation\Rules\Numeric;

class AccountController extends Controller
{
    public function getAccountByUserId(int $userId): Account {
        return Account::getAccountByUserId($userId);
    }

    public function getTotalSavedByAccountId(int $accountId): Numeric | bool {
        return Account::getTotalSavedByAccountId($accountId);
    }
}
