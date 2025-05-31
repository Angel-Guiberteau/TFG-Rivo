<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Account;

class AccountController extends Controller
{
    public function getAccountByUserId(int $userId): Account {
        return Account::getAccountByUserId($userId);
    }
}
