<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public static function getAllIcons(): array {
        return Icon::getAllIconsEnabled()->toArray();
    }

    public static function addIcon(array $data): RedirectResponse {

        if (empty($data['status']) || !$data['status']) { 
            return redirect()
                ->back()
                ->with('error', $data['error'] ?? 'Datos inválidos');
        }

        $icon = '<i class="'.$data['data']['name'].'"></i>';

        $baseCategory = Icon::addIcon($icon);

        if (!$baseCategory) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
            ->back()
            ->with('success', 'Icono añadida correctamente.');
    }

    public static function editIcon(array $data): RedirectResponse {
        
        if (empty($data['status']) || !$data['status']) { 
            return redirect()
                ->back()
                ->with('error', $data['error'] ?? 'Datos inválidos');
        }

        $icon = '<i class="'.$data['data']['name'].'"></i>';

        $baseCategory = Icon::editIcon($data['data']['id'], $icon);

        if (!$baseCategory) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
            ->back()
            ->with('success', 'Icono editado correctamente.');
    }

    public static function deleteIcon(array $data): JsonResponse {
        
        if (empty($data['status']) || !$data['status']) { 
            return response()->json(['error' => $data['error']]);;
        }

        $baseCategory = Icon::deleteIcon($data['data']['id']);

        if (!$baseCategory) {
            return response()->json(['error' => 'Ha habido un error inesperado.']);
        }

        return response()->json(['success' => 'Icono eliminado correctamente.']);
    }
    
}
