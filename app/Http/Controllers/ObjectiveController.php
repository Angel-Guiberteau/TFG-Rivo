<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function getObjectives(): Collection{
        return Objective::getObjectives();
    }
    
    public function addObjective(array $data): bool{
        return Objective::addObjective($data) ? true : false;
    }
    
    public function getObjectivesByAccountId(int $accountId){
        return Objective::getObjectivesByAccountId($accountId);
    }
}
