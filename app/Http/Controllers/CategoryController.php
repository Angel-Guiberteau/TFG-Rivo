<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use App\Models\BaseCategory;
use App\Models\Category;
use App\Models\MovementType;
use App\Models\MovementTypeCategories;
use App\Models\UserCategory;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public static function listCategories(): array {
        return Category::getAllCategoriesEnabled()->toArray();
    }

    public static function numberOfCategories(): int {
        return Category::numberOfCategories();
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
    
    public static function addUserCategory(array $data): bool {
        DB::beginTransaction();
        $category = Category::addUserCategory($data);
        if (!$category) {
            DB::rollBack();
            return false;
        }
        $data['user_id'] = Auth::user()->id;
        $data['category_id'] = $category->id;
        $userCategory = UserCategory::addUserCategory($data);
        if(!$userCategory) {
            DB::rollBack();
            return false;
        }
        foreach ($data['types'] as $key => $value) {
            $data['movement_type_id'] = $value;
            $movementCategory = MovementTypeCategories::addMovementTypeCategory($data);
            if (!$movementCategory) {
                DB::rollBack();
                return false;
            }
        }

        if (!$movementCategory) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public static function getEnabledMovementTypes(): array {
        return MovementType::getEnabledMovementTypes()->toArray();
    }

    public static function getAllBaseCategories(): ?Collection {
        return BaseCategory::listAllBaseCategories();
    }
    
    public static function getPersonalCategoriesByUserId(int $userId): ?Collection {
        return Category::getPersonalCategoriesByUserId($userId);
    }
}
