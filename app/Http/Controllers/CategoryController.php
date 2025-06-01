<?php

namespace App\Http\Controllers;

use App\Models\BaseCategory;
use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class CategoryController extends Controller
{
    public static function listCategories(): array {
        return Category::getAllCategoriesEnabled()->toArray();
    }

    public static function deleteCategory(array $data): JsonResponse {
        if (!$data['status']) {
            return response()->json(['error' => $data['error']]);
        }

        if (!Category::deleteCategory($data['data']['id'])) {
            return response()->json(['error' => 'Ha habido un error inesperado.']);
        }

        return response()->json(['success' => 'Frase borrada correctamente.']);
    }

    public static function getAllBaseCategories(): ?Collection {
        return BaseCategory::listAllBaseCategories();
    }
    
    public static function getPersonalCategoriesByUserId(int $userId): ?Collection {
        return Category::getPersonalCategoriesByUserId($userId);
    }
}
