<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/**
 * Controlador ObjectiveController
 *
 * Gestiona las operaciones CRUD relacionadas con los objetivos de ahorro de los usuarios.
 */
class ObjectiveController extends Controller
{
    /**
     * Obtiene un objetivo por su ID.
     *
     * @param int $id ID del objetivo.
     * @return JsonResponse Datos del objetivo en formato JSON.
     */
    public function getObjective(int $id): JsonResponse {
        return response()->json(Objective::getObjective($id));
    }

    /**
     * Añade un nuevo objetivo.
     *
     * @param array $data Datos del objetivo a añadir.
     * @return bool True si se añadió correctamente, false si falló.
     */
    public function addObjective(array $data): bool {
        return Objective::addObjective($data) ? true : false;
    }

    /**
     * Actualiza un objetivo existente.
     *
     * @param array $data Datos del objetivo con cambios.
     * @return bool True si la actualización fue exitosa, false si falló.
     */
    public function updateObjective(array $data): bool {
        return Objective::updateObjective($data) ? true : false;
    }

    /**
     * Elimina un objetivo por su ID.
     *
     * @param int $id ID del objetivo.
     * @return JsonResponse Resultado en formato JSON con mensaje de éxito o error.
     */
    public function deleteObjective(int $id): JsonResponse {
        if (!Objective::deleteObjective($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Objetivo no encontrado o no eliminado.'
            ], 404);
        }

        return response()->json([
            'success' => 'Objetivo eliminado correctamente.',
        ]);
    }

    /**
     * Obtiene todos los objetivos de una cuenta por su ID.
     *
     * @param int $accountId ID de la cuenta.
     * @return \Illuminate\Database\Eloquent\Collection Colección de objetivos.
     */
    public function getObjectivesByAccountId(int $accountId) {
        return Objective::getObjectivesByAccountId($accountId);
    }
}
