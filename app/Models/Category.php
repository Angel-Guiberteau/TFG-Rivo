<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [ 'name' ];

    public static function getAllCategoriesEnabled(): Collection {
        $category = new self();
        
        return $category->select('id', 'name')
                        ->get();
    }

    public static function addCategory(string $text): bool {
        $category = new self();

        $category->name = $text;

        return $category->save();
    }

    public static function editCategory(array $data): bool {
        $category = self::find($data['id']);
        if ($category) {
            return $category->update(
                [
                    'name' => $data['name'],
                ]
            );
        }

        return false;
    }

    public static function deleteCategory(int $id): bool {
        $category = self::find($id);

        if ($category) {
            return $category->delete();
        }

        return false;
    }
}
