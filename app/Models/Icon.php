<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
