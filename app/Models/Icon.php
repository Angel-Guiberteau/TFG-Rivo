<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Icon extends Model
{
    protected $table = 'icons';

    protected $fillable = [
        'icon',
        'enabled',
    ];
    public function categories()
    {
        return $this->hasMany(Category::class, 'icon_id');
    }

    public static function getAllIconsEnabled(): Collection
    {
        return self::where('enabled', true)
            ->select('id', 'icon')
            ->get();
    }
}
