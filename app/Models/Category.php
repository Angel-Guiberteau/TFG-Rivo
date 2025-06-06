<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'icon_id',
        'enabled',
    ];

    public static function numberOfCategories(): int {
        return self::count();
    }

    public static function addCategory(string $text, int $iconId): array|false {
        $category = new self();

        $category->name = $text;
        $category->icon_id = $iconId;

        if ($category->save()) {
            return $data = [
                'status' => true,
                'categoryId' => $category->id,
            ];
        }

        return false;
    }

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


    public static function addUserCategory(array $data): bool | self {
        $category = new self;

        $category->name = $data['name'];
        $category->icon_id = $data['icon'];

        return $category->save() ? $category : false;
    }

    public static function getCategory(int $categoryId): self|null {
        return self::with('movementTypes')
            ->where('enabled', 1)
            ->find($categoryId);
    }


    public static function deleteCategory(int $id): bool {
        $category = self::find($id);

        if ($category) {
            $category->enabled = 0;
            return $category->save();
        }

        return false;
    }

    public static function getPersonalCategoriesByUserId(int $userId): ?Collection {

        $user = User::with(['personalCategories' => function ($query) {
            $query->where('enabled', 1);
        }, 'personalCategories.icon', 'personalCategories.movementTypes'])->find($userId);

        if (!$user) {
            return collect();
        }


        $categories = $user->personalCategories->map(function ($category) {
            return [
            'id' => $category->id,
            'category_name' => $category->name,
            'icon_id' => $category->icon?->id,
            'icon_html' => $category->icon?->icon,
            'movement_type_ids' => $category->movementTypes->pluck('id')->toArray(),
            'movement_type_names' => $category->movementTypes->pluck('name')->implode(', '),
            ];
        });
        return $categories;
    }

    public function operations(): HasMany {
        return $this->hasMany(Operation::class);
    }

    public function icon(): BelongsTo {
        return $this->belongsTo(Icon::class, 'icon_id');
    }

    public function movementTypes()
    {
        return $this->belongsToMany(MovementType::class, 'movements_types_categories', 'category_id', 'movement_type_id');
    }



}
