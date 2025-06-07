<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\BaseCategory;

/**
 * Controlador BaseCategoryController
 *
 * Gestiona las categorías base disponibles en el sistema (CRUD).
 */
class BaseCategoryController extends Controller
{
    /**
     * Devuelve un listado de todas las categorías base.
     *
     * @return array Lista de categorías base como array.
     */
    public static function listAllBaseCategories(): array {
        return BaseCategory::listAllBaseCategories()->toArray();
    }

    /**
     * Añade una nueva categoría base si los datos son válidos.
     *
     * @param array $data Datos validados de la nueva categoría base.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function addBaseCategory(array $data): RedirectResponse {

        if (empty($data['status']) || !$data['status']) {
            return redirect()
                ->back()
                ->with('error', $data['error'] ?? 'Datos inválidos');
        }

        $baseCategory = BaseCategory::addBaseCategory($data['data']);

        if (!$baseCategory) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
            ->back()
            ->with('success', 'Categoría base añadida correctamente.');
    }

    /**
     * Edita una categoría base existente si los datos son válidos.
     *
     * @param array $data Datos validados con los cambios de la categoría base.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function editBaseCategory(array $data): RedirectResponse {

        if (empty($data['status']) || !$data['status']) {
            return redirect()
                ->back()
                ->with('error', $data['error'] ?? 'Datos inválidos');
        }

        $baseCategory = BaseCategory::editBaseCategory($data['data']);

        if (!$baseCategory) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
            ->back()
            ->with('success', 'Categoría base editada correctamente.');
    }
}
