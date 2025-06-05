<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function getObjectives(): Collection{
        return Objective::getObjectives();
    }
    public function getObjective(int $id): JsonResponse{
        return response()->json(Objective::getObjective($id));
    }

    public function addObjective(array $data): bool{
        return Objective::addObjective($data) ? true : false;
    }

    public function updateObjective(array $data): bool{
        return Objective::updateObjective($data) ? true : false;
    }

    public function deleteObjective(int $id): JsonResponse{
        if(!Objective::deleteObjective($id)){
            return response()->json([
                'status' => 'error',
                'message' => 'Objetivo no encontrado o no eliminado.'
            ], 404);
        };
        return response()->json([
            'success' => 'Objective deleted successfully.'
        ], 200);
    }

    public function getObjectivesByAccountId(int $accountId){
        return Objective::getObjectivesByAccountId($accountId);
    }
}
