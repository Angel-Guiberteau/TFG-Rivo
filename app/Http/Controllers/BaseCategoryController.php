<?php

namespace App\Http\Controllers;

use App\Models\BaseCategory;
use App\Models\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseCategoryController extends Controller
{
    public static function listAllBaseCategories(): array {
        return BaseCategory::listAllBaseCategories()->toArray();
    }

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
