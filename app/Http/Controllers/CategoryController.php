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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public static function numberOfCategories(): int {
        return Category::numberOfCategories();
    }

    public static function deleteCategoryUser(int $id): JsonResponse {
        if (!Category::deleteCategory($id)) {
            return response()->json(['error' => 'No se ha podido borrar la categoría. Póngase en contacto con el equipo soporte.']);
        }

        return response()->json(['success' => 'Categoría borrada correctamente.']);
    }

    public static function deleteCategory(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()->back()->with('error', 'Id erroneo');
        }

        if (!Category::deleteCategory($data['data']['id'])) {
            return redirect()->back()->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()->back()->with('success', 'Categoría borrada correctamente.');
    }

    public static function updateCategory(array $data): bool {

        if (!Category::updateCategory($data)) {
            return false;
        }


        return true;
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
        $movementCategory = null;
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
        DB::commit();
        return true;
    }

    public static function getCategory(int $categoryId): Category {
        return Category::getCategory($categoryId);
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
