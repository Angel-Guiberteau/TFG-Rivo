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

/**
 * Controlador CategoryController
 *
 * Gestiona las operaciones relacionadas con las categorías (base, personales y su relación con tipos de movimiento).
 */
class CategoryController extends Controller
{
    /**
     * Devuelve el número total de categorías registradas.
     *
     * @return int
     */
    public static function numberOfCategories(): int {
        return Category::numberOfCategories();
    }

    /**
     * Elimina una categoría de usuario por su ID.
     *
     * @param int $id ID de la categoría.
     * @return JsonResponse
     */
    public static function deleteCategoryUser(int $id): JsonResponse {
        if (!Category::deleteCategory($id)) {
            return response()->json(['error' => 'No se ha podido borrar la categoría. Póngase en contacto con el equipo soporte.']);
        }

        return response()->json(['success' => 'Categoría borrada correctamente.']);
    }

    /**
     * Elimina una categoría a partir de los datos validados.
     *
     * @param array $data Datos validados con el ID de la categoría.
     * @return RedirectResponse
     */
    public static function deleteCategory(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()->back()->with('error', 'Id erroneo');
        }

        if (!Category::deleteCategory($data['data']['id'])) {
            return redirect()->back()->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()->back()->with('success', 'Categoría borrada correctamente.');
    }

    /**
     * Actualiza una categoría existente.
     *
     * @param array $data Datos validados de actualización.
     * @return bool
     */
    public static function updateCategory(array $data): bool {
        if (!Category::updateCategory($data)) {
            return false;
        }

        return true;
    }

    /**
     * Añade una nueva categoría personalizada para el usuario autenticado.
     *
     * @param array $data Datos necesarios para crear la categoría.
     * @return bool
     */
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

    /**
     * Obtiene una categoría específica por su ID.
     *
     * @param int $categoryId
     * @return Category
     */
    public static function getCategory(int $categoryId): Category {
        return Category::getCategory($categoryId);
    }

    /**
     * Devuelve los tipos de movimiento habilitados.
     *
     * @return array
     */
    public static function getEnabledMovementTypes(): array {
        return MovementType::getEnabledMovementTypes()->toArray();
    }

    /**
     * Devuelve todas las categorías base disponibles.
     *
     * @return Collection|null
     */
    public static function getAllBaseCategories(): ?Collection {
        return BaseCategory::listAllBaseCategories();
    }

    /**
     * Devuelve las categorías personales asociadas a un usuario.
     *
     * @param int $userId
     * @return Collection|null
     */
    public static function getPersonalCategoriesByUserId(int $userId): ?Collection {
        return Category::getPersonalCategoriesByUserId($userId);
    }
}
