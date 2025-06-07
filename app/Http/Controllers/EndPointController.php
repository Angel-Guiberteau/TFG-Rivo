<?php

namespace App\Http\Controllers;

use App\Models\EndPoint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador EndPointController
 *
 * Gestiona la lógica CRUD y consulta de endpoints configurables del sistema.
 */
class EndPointController extends Controller
{
    /**
     * Obtiene todos los endpoints habilitados en el sistema.
     *
     * @return array Lista de endpoints habilitados.
     */
    public static function getAllEnabledEndPoints(): array {
        return EndPoint::getAllEnabledEndPoints()->toArray();
    }

    /**
     * Devuelve un endpoint por su ID con procesamiento adicional de datos.
     *
     * Si el endpoint no existe, redirige con error.
     * Si existe, añade campos 'return_data_name' y 'return_data_types' al array devuelto.
     *
     * @param int $id ID del endpoint.
     * @return array|RedirectResponse Array con los datos del endpoint o redirección en caso de error.
     */
    public static function getEndPointById(int $id): array|RedirectResponse {
        $endPoint = EndPoint::getEndPointById($id);

        if (!$endPoint) {
            return redirect()
                ->back()
                ->with('errors', 'Ha habido un error inesperado.');
        }

        $data = $endPoint->toArray();

        $returnData = $data['return_data'] ?? '';
        $returnData = trim($returnData, '[]');
        $parts = explode('|', $returnData);

        $nombres = [];
        $tipos = [];

        foreach ($parts as $part) {
            $part = trim($part);

            if (preg_match("/^'(.*?)'\s+(\w+)$/", $part, $matches)) {
                $nombres[] = $matches[1];
                $tipos[] = $matches[2];
            }
        }

        $data['return_data_name'] = $nombres;
        $data['return_data_types'] = $tipos;

        return $data;
    }

    /**
     * Añade un nuevo endpoint al sistema si los datos son válidos.
     *
     * @param array $data Datos validados del endpoint.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function addEndPoint(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()->back()->with('error', $data['error']);
        }

        if (!EndPoint::addEndPoint($data['data'])) {
            return redirect()->back()->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()->route('endPoints')->with('success', 'Endpoint añadido correctamente.');
    }

    /**
     * Edita un endpoint existente si los datos son válidos.
     *
     * @param array $data Datos validados del endpoint a editar.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function editEndPoint(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()->back()->with('error', $data['error']);
        }

        if (!EndPoint::editEndPoint($data['data'])) {
            return redirect()->back()->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()->route('endPoints')->with('success', 'Endpoint modificado correctamente.');
    }

    /**
     * Elimina un endpoint si el ID es válido.
     *
     * @param array $data Datos que contienen el ID del endpoint a eliminar.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function deleteEndPoint(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()
                    ->back()
                    ->with('error', $data['error']);
        }

        if (!EndPoint::deleteEndPoint($data['data']['id'])) {
            return redirect()
                    ->back()
                    ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
                ->back()
                ->with('success', 'Endpoint eliminado correctamente.');
    }
}
