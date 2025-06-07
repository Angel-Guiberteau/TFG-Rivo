<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Role
 *
 * Representa un rol dentro del sistema (por ejemplo, admin, user, etc.).
 */
class Role extends Model
{
    /**
     * Relación uno a muchos con los usuarios.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
