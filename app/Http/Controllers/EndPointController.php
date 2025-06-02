<?php

namespace App\Http\Controllers;

use App\Models\EndPoint;
use Illuminate\Http\Request;

class EndPointController extends Controller
{
    public static function getAllEnabledEndPoints(): array {
        return EndPoint::getAllEnabledEndPoints()->toArray();
    }
}
