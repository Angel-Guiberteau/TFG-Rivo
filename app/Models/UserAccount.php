<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Clase UserAccount
 *
 * Representa la relación entre un usuario y sus cuentas.
 */
class UserAccount extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'users_accounts';

    /**
     * Atributos asignables masivamente.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'account_id',
        'enabled',
    ];

    /**
     * Asocia un usuario a una cuenta.
     *
     * @param int $userId
     * @param int $accountId
     * @return bool|self
     */
    public static function addUserAccount(int $userId, int $accountId)
    {
        $userAccount = new self;

        $userAccount->user_id = $userId;
        $userAccount->account_id = $accountId;

        return $userAccount->save() ? $userAccount : false;
    }

    /**
     * Obtiene todas las cuentas activas asociadas a un usuario.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAccountsByUserId(int $userId)
    {
        $accountIds = self::where('user_id', $userId)
            ->where('enabled', 1)
            ->pluck('account_id');

        return Account::whereIn('id', $accountIds)->get();
    }

    /**
     * Elimina (desactiva) una cuenta personal del usuario.
     *
     * @param int $userId
     * @param int $accountId
     * @return int Número de registros actualizados
     */
    public static function deletePersonalAccount(int $userId, int $accountId)
    {
        $updated = self::where('user_id', $userId)
            ->where('account_id', $accountId)
            ->update(['enabled' => 0]);

        Account::where('id', $accountId)->update(['enabled' => 0]);

        return $updated;
    }

    /**
     * Actualiza los datos de una cuenta personal.
     *
     * @param int $accountId
     * @param string $name
     * @param float $balance
     * @param string $currency
     * @param mixed $enabled
     * @return bool
     */
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

        if ((int)$enabled === 1 && $account->enabled != 1) {
            $account->enabled = 1;
            $hasChanges = true;
        }

        if ($enabled === null && $account->enabled != 0) {
            $account->enabled = 0;
            $hasChanges = true;
        }

        return $hasChanges ? $account->save() : true;
    }

    /**
     * Crea una cuenta personal y la asocia al usuario.
     *
     * @param int $userId
     * @param string $name
     * @param float $balance
     * @param string $currency
     * @param mixed $enabled
     * @return bool
     */
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

            self::create([
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
