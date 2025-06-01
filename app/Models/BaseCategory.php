<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BaseCategory extends Model
{
    protected $table = 'base_categories';
    protected $fillable = [ 'categories_id' ];

    public static function listAllBaseCategories(): Collection {
        return self::with(['category.icon', 'category.movementTypes'])
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

    public static function addBaseCategory(array $data): BaseCategory {
        DB::beginTransaction();
        try {
            $category = Category::firstOrCreate(
                ['name' => $data['name']],
                ['icon_id' => $data['iconId'] ?? null]
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

    public static function editBaseCategory(array $data): ?BaseCategory {
        DB::beginTransaction();

        try {
            $baseCategory = self::find($data['id']);
            if (!$baseCategory) {
                DB::rollBack();
                return null; // No existe
            }

            $category = Category::updateOrCreate(
                ['id' => $baseCategory->categories_id],
                ['name' => $data['name'], 'icon_id' => $data['iconId'] ?? null]
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
    
    public function category():  BelongsTo {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
