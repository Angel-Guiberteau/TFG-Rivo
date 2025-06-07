<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Modelo Category que representa las categorías del sistema.
 */
class Category extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon_id',
        'enabled',
    ];

    /**
     * Obtiene el número total de categorías registradas.
     *
     * @return int
     */
    public static function numberOfCategories(): int {
        return self::count();
    }

    /**
     * Añade una nueva categoría con un nombre y un icono.
     *
     * @param string $text Nombre de la categoría.
     * @param int $iconId ID del icono asociado.
     * @return array|false Datos de estado y ID de la categoría o false si falla.
     */
    public static function addCategory(string $text, int $iconId): array|false {
        $category = new self();

        $category->name = $text;
        $category->icon_id = $iconId;

        if ($category->save()) {
            return [
                'status' => true,
                'categoryId' => $category->id,
            ];
        }

        return false;
    }

    /**
     * Actualiza los datos de una categoría existente.
     *
     * @param array $data Datos actualizados de la categoría.
     * @return bool True si se actualiza correctamente, false si falla.
     */
    public static function updateCategory(array $data): bool {
        $category = self::with('movementTypes')->find($data['id']);

        if (!$category) {
            return false;
        }

        if (isset($data['name'])) {
            $category->name = $data['name'];
        }

        if (isset($data['icon'])) {
            $category->icon_id = $data['icon'];
        }

        if (!$category->save()) {
            return false;
        }

        if (isset($data['types'])) {
            $category->movementTypes()->sync($data['types']);
        }

        return true;
    }

    /**
     * Añade una categoría personalizada de usuario.
     *
     * @param array $data Datos de la categoría.
     * @return bool|self Instancia de la categoría si se guarda, false si falla.
     */
    public static function addUserCategory(array $data): bool|self {
        $category = new self;

        $category->name = $data['name'];
        $category->icon_id = $data['icon'];

        return $category->save() ? $category : false;
    }

    /**
     * Obtiene una categoría habilitada por su ID con sus tipos de movimiento.
     *
     * @param int $categoryId ID de la categoría.
     * @return self|null
     */
    public static function getCategory(int $categoryId): self|null {
        return self::with('movementTypes')
            ->where('enabled', 1)
            ->find($categoryId);
    }

    /**
     * Marca una categoría como deshabilitada.
     *
     * @param int $id ID de la categoría.
     * @return bool True si se deshabilita correctamente, false si falla.
     */
    public static function deleteCategory(int $id): bool {
        $category = self::find($id);

        if ($category) {
            $category->enabled = 0;
            return $category->save();
        }

        return false;
    }

    /**
     * Obtiene las categorías personales habilitadas de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return Collection|null
     */
    public static function getPersonalCategoriesByUserId(int $userId): ?Collection {
        $user = User::with(['personalCategories' => function ($query) {
            $query->where('enabled', 1);
        }, 'personalCategories.icon', 'personalCategories.movementTypes'])->find($userId);

        if (!$user) {
            return collect();
        }

        return $user->personalCategories->map(function ($category) {
            return [
                'id' => $category->id,
                'category_name' => $category->name,
                'icon_id' => $category->icon?->id,
                'icon_html' => $category->icon?->icon,
                'movement_type_ids' => $category->movementTypes->pluck('id')->toArray(),
                'movement_type_names' => $category->movementTypes->pluck('name')->implode(', '),
            ];
        });
    }

    /**
     * Relación uno a muchos con operaciones.
     *
     * @return HasMany
     */
    public function operations(): HasMany {
        return $this->hasMany(Operation::class);
    }

    /**
     * Relación con el icono de la categoría.
     *
     * @return BelongsTo
     */
    public function icon(): BelongsTo {
        return $this->belongsTo(Icon::class, 'icon_id');
    }

    /**
     * Relación muchos a muchos con tipos de movimiento.
     *
     * @return BelongsToMany
     */
    public function movementTypes(): BelongsToMany {
        return $this->belongsToMany(MovementType::class, 'movements_types_categories', 'category_id', 'movement_type_id');
    }
}
