<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EndPoint extends Model
{
    protected $table = 'endpoints';
    protected $fillable = [ 
        'name',
        'url',
        'method',
        'parameters',
        'return',
        'enabled',
    ];

    public static function getAllEnabledEndPoints(): Collection {
        $endPoint = new self();
        
        return $endPoint->where('enabled', 1)
                        ->get();
    }
}
