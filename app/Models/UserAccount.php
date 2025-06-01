<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $accountIds = Self::where('user_id', $userId)
            ->where('enabled', 1)
            ->pluck('account_id');
        return Account::whereIn('id', $accountIds)
            ->get();
    }

    public static function deletePersonalAccount(int $userId, int $accountId){
        
        $updated = Self::where('user_id', $userId)
            ->where('account_id', $accountId)
            ->update(['enabled' => 0]);

        
        Account::where('id', $accountId)->update(['enabled' => 0]);

        return $updated;
    }

    public static function updatePersonalAccount($accountId, $name, $balance, $currency, $enabled)
    {
        $account = Account::find($accountId);

        if (!$account) {
            return false;
        }

        $hasChanges = false;

        if ($account->name !== $name) {
            $account->name = $name;
            $hasChanges = true;
        }

        if (floatval($account->balance) !== floatval($balance)) {
            $account->balance = $balance;
            $hasChanges = true;
        }

        if ($account->currency !== $currency) {
            $account->currency = $currency;
            $hasChanges = true;
        }

        if ((int)$enabled === 1 && $account->enabled != 1)
        {
            $account->enabled = 1;
            $hasChanges = true;
        }

        if ($enabled === null && $account->enabled != 0) {
            $account->enabled = 0;
            $hasChanges = true;
        }

        if ($hasChanges) {
            return $account->save();
        }

        return true;
    }



    public static function addPersonalAccount($userId, $name, $balance, $currency, $enabled)
    {
        try {
            DB::beginTransaction();

            $enabled = (int)$enabled === 1 ? 1 : 0;

            $account = new Account();
            $account->name = $name;
            $account->balance = $balance;
            $account->currency = $currency;
            $account->enabled = $enabled;

            if (!$account->save()) {
                DB::rollBack();
                return false;
            }

            UserAccount::create([
                'user_id' => $userId,
                'account_id' => $account->id,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }


}
