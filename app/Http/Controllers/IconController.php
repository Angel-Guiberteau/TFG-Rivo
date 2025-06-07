<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Controlador IconController
 *
 * Gestiona las operaciones relacionadas con los iconos disponibles en el sistema.
 */
class IconController extends Controller
{
    /**
     * Obtiene todos los iconos habilitados.
     *
     * @return array Lista de iconos habilitados como array.
     */
    public static function getAllIcons(): array {
        return Icon::getAllIconsEnabled()->toArray();
    }

    /**
     * Devuelve el número total de iconos registrados.
     *
     * @return int Número de iconos.
     */
    public static function numberOfIcons(): int {
        return Icon::numberOfIcons();
    }

    /**
     * Añade un nuevo icono al sistema.
     *
     * @param array $data Datos validados para el nuevo icono.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
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

    /**
     * Edita un icono existente.
     *
     * @param array $data Datos validados con ID e información del icono.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
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

    /**
     * Elimina un icono existente del sistema.
     *
     * @param array $data Datos que contienen el ID del icono a eliminar.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function deleteIcon(array $data): RedirectResponse {
        if (empty($data['status']) || !$data['status']) {
            return redirect()->back()->with('error', $data['error']);
        }

        $baseCategory = Icon::deleteIcon($data['data']['id']);

        if (!$baseCategory) {
            return redirect()->back()->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()->back()->with('success', 'Icono eliminado correctamente.');
    }
}
