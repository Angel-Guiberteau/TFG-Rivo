<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Account;
use Illuminate\Validation\Rules\Numeric;

/**
 * Controlador AccountController
 *
 * Gestiona la lógica relacionada con las cuentas de los usuarios.
 */
class AccountController extends Controller
{
    /**
     * Obtiene la cuenta asociada a un usuario por su ID.
     *
     * @param int $userId ID del usuario.
     * @return Account Instancia del modelo Account.
     */
    public function getAccountByUserId(int $userId): Account {
        return Account::getAccountByUserId($userId);
    }

    /**
     * Devuelve el total ahorrado por una cuenta específica.
     *
     * @param int $accountId ID de la cuenta.
     * @return Numeric|bool Total ahorrado o false si la cuenta no existe.
     */
    public function getTotalSavedByAccountId(int $accountId): Numeric | bool {
        return Account::getTotalSavedByAccountId($accountId);
    }
}
