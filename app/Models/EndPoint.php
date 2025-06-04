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
        'return_data',
        'enabled',
    ];

    public static function getAllEnabledEndPoints(): Collection {
        $endPoint = new self();
        
        return $endPoint->where('enabled', 1)
                        ->get();
    }

    public static function getEndPointById(int $id): ?EndPoint {
        return self::select('id', 'name', 'url', 'method', 'parameters', 'return', 'return_data')
                    ->where('id', $id)
                    ->where('enabled', 1)
                    ->first();
    }

    public static function addEndPoint( array $data ): bool {
        $endPoint = new self();

        $endPoint->name = $data['name'];
        $endPoint->url = $data['url'];
        $endPoint->method = $data['method'];
        $endPoint->parameters = $data['parameters'];
        $endPoint->return = $data['return'];
        $endPoint->return_data = $data['returnData'];
        $endPoint->description = $data['description'];

        return $endPoint->save();
    }

    public static function editEndPoint( array $data ): bool {
        $endPoint = self::find($data['id']);

        $change = false;
        if ($endPoint) {
            if ($endPoint->name != $data['name']) {

                $endPoint->name = $data['name'];
                $change = true;

            }
            if ($endPoint->url = $data['url']) {

                $endPoint->url = $data['url'];
                $change = true;
            }
            
            if ($endPoint->method = $data['method']) {
                
                $endPoint->method = $data['method'];
                $change = true;
            }

            if ($endPoint->parameters = $data['parameters']) {
                
                $endPoint->parameters = $data['parameters'];
                $change = true;
            }

            if ($endPoint->return = $data['return']) {
                
                $endPoint->return = $data['return'];
                $change = true;
            }

            if ($endPoint->return_data = $data['returnData']) {
                
                $endPoint->return_data = $data['returnData'];
                $change = true;
            }
            
            if ($endPoint->description = $data['description']) {
                
                $endPoint->description = $data['description'];
                $change = true;
            }

            if ($change) {
                return $endPoint->update();
            }
        }

        return $change;
    }

    public static function deleteEndPoint( int $id ): bool {
        $endPoint = self::find($id);

        if ($endPoint) {
            $endPoint->enabled = 0;
            return $endPoint->save();
        }

        return false;
    }
}
