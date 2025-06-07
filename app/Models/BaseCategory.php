<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Modelo BaseCategory que representa las categorías base del sistema.
 */
class BaseCategory extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'base_categories';

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['categories_id'];

    /**
     * Obtiene todas las categorías base habilitadas junto con sus iconos y tipos de movimiento.
     *
     * @return Collection
     */
    public static function listAllBaseCategories(): Collection {
        $categoriesEnabled = Category::where('enabled', true)->pluck('id')->toArray();

        return self::with(['category.icon', 'category.movementTypes'])
            ->whereIn('categories_id', $categoriesEnabled)
            ->get()
            ->map(function ($base) {
                return [
                    'id' => $base->categories_id,
                    'category_name' => $base->category->name,
                    'icon_id' => $base->category->icon?->id,
                    'icon_html' => $base->category->icon?->icon,
                    'movement_type_ids' => $base->category->movementTypes->pluck('id')->toArray(),
                    'movement_type_names' => $base->category->movementTypes->pluck('name')->implode(', '),
                ];
            });
    }

    /**
     * Crea una nueva categoría base y sincroniza sus tipos de movimiento.
     *
     * @param array $data Datos para la creación de la categoría.
     * @return BaseCategory
     * @throws \Exception Si ocurre un error durante la transacción.
     */
    public static function addBaseCategory(array $data): BaseCategory {
        DB::beginTransaction();
        try {
            $category = Category::firstOrCreate(
                ['name' => $data['name']],
                ['icon_id' => $data['icon'] ?? null]
            );

            if (!empty($data['types'])) {
                $category->movementTypes()->sync($data['types']);
            }

            $baseCategory = self::create([
                'categories_id' => $category->id,
            ]);

            DB::commit();

            return $baseCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Edita una categoría base existente actualizando su nombre, icono y tipos de movimiento.
     *
     * @param array $data Datos para la edición de la categoría base.
     * @return BaseCategory|null Retorna la categoría editada o null si no se encontró.
     * @throws \Exception Si ocurre un error durante la transacción.
     */
    public static function editBaseCategory(array $data): ?BaseCategory {
        DB::beginTransaction();

        try {
            $baseCategory = self::find($data['id']);
            if (!$baseCategory) {
                DB::rollBack();
                return null;
            }

            $category = Category::updateOrCreate(
                ['id' => $baseCategory->categories_id],
                ['name' => $data['name'], 'icon_id' => $data['icon'] ?? null]
            );

            if (!empty($data['types'])) {
                $category->movementTypes()->sync($data['types']);
            }

            if ($baseCategory->categories_id !== $category->id) {
                $baseCategory->categories_id = $category->id;
                $baseCategory->save();
            }

            DB::commit();

            return $baseCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Relación con el modelo Category (categoría asociada).
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
