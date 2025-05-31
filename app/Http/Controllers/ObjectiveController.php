<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function getObjectives(){
        return Objective::getObjectives();
    }
    
    public function getObjectivesByAccountId(int $accountId){
        return Objective::getObjectivesByAccountId($accountId);
    }
}
