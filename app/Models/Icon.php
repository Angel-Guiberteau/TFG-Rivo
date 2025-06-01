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

    public static function getAllIconsEnabled(): Collection
    {
        return self::select('id', 'icon')
            ->where('enabled', true)
            ->get();
    }

    public static function addIcon( string $name ): bool {
        $icon = new self();

        $icon->icon = $name;
        $icon->enabled = 1;

        return $icon->save();
    }

    public static function editIcon( int $id, string $iconClass): bool {
        $icon = self::find($id);

        if ($icon) {
            return $icon->update(
                [
                    'icon' => $iconClass,
                ]
            );
        }

        return false;
    }

    public static function deleteIcon(int $id): bool {
        $icon = self::find($id);

        if ($icon) {
            $icon->enabled = 0;
            return $icon->save();
        }

        return false;
    }

    public function categories(): HasMany {
        return $this->hasMany(Category::class, 'icon_id');
    }
}
