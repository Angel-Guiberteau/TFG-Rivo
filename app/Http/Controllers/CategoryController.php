<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public static function listCategories(): View {
        $data = Category::getAllCategoriesEnabled();

        return view('admin.categories.categories')->with('categories', $data);
    }

    public static function addCategory(array $data): RedirectResponse {
        if (!$data['status']) { 
            return redirect()
                ->back()
                ->with('error', $data['error']);
        }
        
        if (!Category::addCategory($data['data']['name'])) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
                ->back()
                ->with('success', 'Frase añadida correctamente.');
    }

    public static function editCategory(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()
                ->back()
                ->with('error', $data['error']);
        }
        if (!Category::editCategory($data['data'])) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }
        
        return redirect()
                ->back()
                ->with('success', 'Frase editada correctamente.');
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
}
