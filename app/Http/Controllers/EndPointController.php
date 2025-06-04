<?php

namespace App\Http\Controllers;

use App\Models\EndPoint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class EndPointController extends Controller
{
    public static function getAllEnabledEndPoints(): array {
        return EndPoint::getAllEnabledEndPoints()->toArray();
    }

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


    public static function addEndPoint( array $data ): JsonResponse {
        if (!$data['status']) { 
            return response()->json(['error' => $data['error']]);
        }

        if (!EndPoint::addEndPoint($data['data'])) {
            return response()->json(['error' => 'Ha habido un error inesperado.']);
        }

        return response()->json(['success' => 'Endpoint añadido correctamente.']);
    }

    public static function editEndPoint( array $data ): JsonResponse{
        if (!$data['status']) { 
            return response()->json(['error' => $data['error']]);
        }

        if (!EndPoint::editEndPoint($data['data'])) {
            return response()->json(['error' => 'Ha habido un error inesperado.']);
        }

        return response()->json(['success' => 'Endpoint modificado correctamente.']);
    }

    public static function deleteEndPoint( array $data ): JsonResponse {
        if (!$data['status']) {
            return response()->json(['error' => $data['error']]);
        }

        if (!EndPoint::deleteEndPoint($data['data']['id'])) {
            return response()->json(['error' => 'Ha habido un error inesperado.']);
        }

        return response()->json(['success' => 'Endpoint borrado correctamente.']);
    }
}
