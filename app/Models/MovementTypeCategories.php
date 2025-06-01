<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementTypeCategories extends Model
{
    protected $table = 'movements_types_categories';
    protected $fillable = [ 
        'movement_type_id',
        'category_id',
    ];

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

}
