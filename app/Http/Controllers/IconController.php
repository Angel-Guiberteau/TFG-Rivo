<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public static function getAllIcons(): array {
        return Icon::getAllIcons()->toArray();
    }
}
