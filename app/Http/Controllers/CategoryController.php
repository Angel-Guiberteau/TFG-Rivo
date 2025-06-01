<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MovementType;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

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

        return response()->json(['success' => 'Caregoría borrada correctamente.']);
    }

    public static function getAllMovementTypes(): array {
        return MovementType::getAllMovementTypes()->toArray();
    }
}
