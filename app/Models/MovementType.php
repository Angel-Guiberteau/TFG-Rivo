<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    protected $table = 'movements_types';
    protected $fillable = [ 
        'name',
        'enabled',
    ];

    public static function getEnabledMovementTypes()
    {
        return self::where('enabled', 1)->get();
    }
}
