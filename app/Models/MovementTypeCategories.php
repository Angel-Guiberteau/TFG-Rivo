<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo MovementTypeCategories que representa la relación entre tipos de movimiento y categorías.
 */
class MovementTypeCategories extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'movements_types_categories';

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'movement_type_id',
        'category_id',
    ];

    /**
     * Sincroniza los tipos de movimiento asociados a una categoría,
     * añadiendo nuevos y eliminando los que ya no están presentes.
     *
     * @param int $categoryId
     * @param array $newTypeIds
     * @return void
     */
    public static function syncTypesOfCategory(int $categoryId, array $newTypeIds): void
    {
        $currentTypeIds = self::where('category_id', $categoryId)->pluck('movement_type_id')->toArray();

        $toAdd = array_diff($newTypeIds, $currentTypeIds);
        $toDelete = array_diff($currentTypeIds, $newTypeIds);

        if (!empty($toDelete)) {
            self::where('category_id', $categoryId)
                ->whereIn('movement_type_id', $toDelete)
                ->delete();
        }

        foreach ($toAdd as $typeId) {
            self::create([
                'category_id' => $categoryId,
                'movement_type_id' => $typeId
            ]);
        }
    }

    /**
     * Añade una nueva relación entre tipo de movimiento y categoría.
     *
     * @param array $data
     * @return bool|self
     */
    public static function addMovementTypeCategory(array $data): bool | self
    {
        $movementTypeCategory = new self;

        $movementTypeCategory->movement_type_id = $data['movement_type_id'];
        $movementTypeCategory->category_id = $data['category_id'];

        return $movementTypeCategory->save() ? $movementTypeCategory : false;
    }

}
