<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Modelo Icon que representa los iconos utilizados en categorías y otras entidades.
 */
class Icon extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'icons';

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'icon',
        'enabled',
    ];

    /**
     * Obtiene todos los iconos habilitados.
     *
     * @return Collection
     */
    public static function getAllIconsEnabled(): Collection
    {
        return self::select('id', 'icon')
            ->where('enabled', true)
            ->get();
    }

    /**
     * Devuelve el número total de iconos habilitados.
     *
     * @return int
     */
    public static function numberOfIcons(): int {
        return self::where('enabled', 1)
                    ->count();
    }

    /**
     * Crea un nuevo icono con el nombre proporcionado.
     *
     * @param string $name
     * @return bool
     */
    public static function addIcon(string $name): bool {
        $icon = new self();

        $icon->icon = $name;
        $icon->enabled = 1;

        return $icon->save();
    }

    /**
     * Edita la clase CSS de un icono existente.
     *
     * @param int $id
     * @param string $iconClass
     * @return bool
     */
    public static function editIcon(int $id, string $iconClass): bool {
        $icon = self::find($id);

        if ($icon) {
            return $icon->update(
                [
                    'icon' => $iconClass,
                ]
            );
        }

        return false;
    }

    /**
     * Deshabilita un icono lógico por su ID.
     *
     * @param int $id
     * @return bool
     */
    public static function deleteIcon(int $id): bool {
        $icon = self::find($id);

        if ($icon) {
            $icon->enabled = 0;
            return $icon->save();
        }

        return false;
    }

    /**
     * Relación con las categorías que usan este icono.
     *
     * @return HasMany
     */
    public function categories(): HasMany {
        return $this->hasMany(Category::class, 'icon_id');
    }
}
