<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Numeric;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'balance',
        'total_saved',
        'currency',
        'enabled',
    ];

    public static function addAccount(Array $data): bool | self{

        $account = new self;

        $account->name = $data['account_name'];

        return $account->save() ? $account : false;
    }

    public static function getAccountByUserId(int $userId): ?Account {
        return self::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->first();
    }

    public static function updateBalance(int $accountId, float $total): bool {
        $account = self::where('id', $accountId)
            ->first();

        $account->balance = round($total, 2);

        return $account->save();
    }

    public static function updateAccountBalance(int $accountId, float $amount, bool $negative = false): bool {
        $account = self::find($accountId);

        if (!$account) {
            return false;
        }
        if ($negative) {
            $account->balance -= $amount;
        } else {
            $account->balance += $amount;
        }


        return $account->save();
    }
    public static function addIncomeToBalance(int $accountId, float $amount): bool {
        $account = self::find($accountId);

        if (!$account) {
            return false;
        }

        $account->balance += $amount;

        return $account->save();
    }

    public static function addExpenseToBalance(int $accountId, float $amount): bool {
        $account = self::find($accountId);

        if (!$account) {
            return false;
        }

        $account->balance -= $amount;

        return $account->save();
    }

    public static function updateSaveToTotalSave(int $accountId, float $amount, bool $negative = false): bool {
        $account = self::find($accountId);

        if (!$account) {
            return false;
        }
        if(!$negative)
            $account->total_saved += $amount;
        else
            $account->total_saved -= $amount;

        return $account->save();
    }

    public static function addSaveToTotalSave(int $accountId, float $amount): bool {
        $account = self::find($accountId);

        if (!$account) {
            return false;
        }

        $account->total_saved += $amount;

        return $account->save();
    }

    public static function getTotalSavedByAccountId(int $accountId): Numeric | bool{
        $account = self::find($accountId);

        if (!$account) {
            return false;
        }

        return $account->total_saved;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id');
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function icon()
    {
        return $this->belongsTo(Icon::class, 'icon_id');
    }
}
