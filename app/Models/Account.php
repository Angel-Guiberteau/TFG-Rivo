<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Numeric;

/**
 * Modelo que representa una cuenta financiera de un usuario.
 *
 * @package App\Models
 */
class Account extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * Atributos asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'balance',
        'total_saved',
        'currency',
        'enabled',
    ];

    /**
     * Añade una nueva cuenta.
     *
     * @param array $data Datos de la cuenta.
     * @return bool|self Retorna la instancia de la cuenta si se crea correctamente, false en caso contrario.
     */
    public static function addAccount(Array $data): bool | self {
        $account = new self;
        $account->name = $data['account_name'];
        return $account->save() ? $account : false;
    }

    /**
     * Obtiene la cuenta asociada a un usuario.
     *
     * @param int $userId ID del usuario.
     * @return Account|null
     */
    public static function getAccountByUserId(int $userId): ?Account {
        return self::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->first();
    }

    /**
     * Actualiza el balance de la cuenta.
     *
     * @param int $accountId ID de la cuenta.
     * @param float $amount Monto a actualizar.
     * @param bool $negative Indica si se debe restar el monto.
     * @return bool
     */
    public static function updateAccountBalance(int $accountId, float $amount, bool $negative = false): bool {
        $account = self::find($accountId);
        if (!$account) return false;
        $account->balance += $negative ? -$amount : $amount;
        return $account->save();
    }

    /**
     * Añade un ingreso al balance de la cuenta.
     *
     * @param int $accountId ID de la cuenta.
     * @param float $amount Monto a añadir.
     * @return bool
     */
    public static function addIncomeToBalance(int $accountId, float $amount): bool {
        $account = self::find($accountId);
        if (!$account) return false;
        $account->balance += $amount;
        return $account->save();
    }

    /**
     * Resta un gasto del balance de la cuenta.
     *
     * @param int $accountId ID de la cuenta.
     * @param float $amount Monto a restar.
     * @return bool
     */
    public static function addExpenseToBalance(int $accountId, float $amount): bool {
        $account = self::find($accountId);
        if (!$account) return false;
        $account->balance -= $amount;
        return $account->save();
    }

    /**
     * Actualiza el total ahorrado de la cuenta.
     *
     * @param int $accountId ID de la cuenta.
     * @param float $amount Monto a ajustar.
     * @param bool $negative Si es true, se resta; si no, se suma.
     * @return bool
     */
    public static function updateSaveToTotalSave(int $accountId, float $amount, bool $negative = false): bool {
        $account = self::find($accountId);
        if (!$account) return false;
        $account->total_saved += $negative ? -$amount : $amount;
        return $account->save();
    }

    /**
     * Añade un ahorro al total ahorrado.
     *
     * @param int $accountId ID de la cuenta.
     * @param float $amount Monto a añadir.
     * @return bool
     */
    public static function addSaveToTotalSave(int $accountId, float $amount): bool {
        $account = self::find($accountId);
        if (!$account) return false;
        $account->total_saved += $amount;
        return $account->save();
    }

    /**
     * Obtiene el total ahorrado por ID de cuenta.
     *
     * @param int $accountId ID de la cuenta.
     * @return Numeric|bool
     */
    public static function getTotalSavedByAccountId(int $accountId): Numeric | bool {
        $account = self::find($accountId);
        if (!$account) return false;
        return $account->total_saved;
    }

    /**
     * Relación con el modelo User (usuarios asociados a la cuenta).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id');
    }

    /**
     * Relación con los objetivos financieros de la cuenta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objectives() {
        return $this->hasMany(Objective::class);
    }

    /**
     * Relación con las operaciones financieras realizadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations() {
        return $this->hasMany(Operation::class);
    }

    /**
     * Relación con el icono asignado a la cuenta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function icon() {
        return $this->belongsTo(Icon::class, 'icon_id');
    }
}
