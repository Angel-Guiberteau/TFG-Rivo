<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Icon extends Model
{
    protected $table = 'icons';

    protected $fillable = [
        'icon',
        'enabled',
    ];

    public static function getAllIcons(): Collection{
        return self::select('id', 'icon')->where('enabled', 1)->get();
    }

    public function categories(): HasMany {
        return $this->hasMany(Category::class, 'icon_id');
    }

    public static function getAllIconsEnabled(): Collection
    {
        return self::where('enabled', true)
            ->select('id', 'icon')
            ->get();
    }
}
