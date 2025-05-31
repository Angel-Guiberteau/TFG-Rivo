<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'users_accounts';

    protected $fillable = [
        'user_id',
        'account_id',
        'enabled',
    ];

    public static function addUserAccount(int $userId, int $accountId){
        $userAccount = new Self;

        $userAccount->user_id = $userId;
        $userAccount->account_id = $accountId;

        return $userAccount->save() ? $userAccount : false;

    }

    public static function getAccountsByUserId(int $userId){
        $accountIds = Self::where('user_id', $userId)->pluck('account_id');
        return Account::whereIn('id', $accountIds)->get();
    }
}
