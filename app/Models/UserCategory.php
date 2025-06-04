<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    protected $table = 'user_categories';

    protected $fillable = [
        'user_id',
        'categories_id',
    ];

    public $timestamps = true;

    public static function addUserCategory(array $data): bool | self
    {
        $userCategory = new self;

        $userCategory->user_id = $data['user_id'];
        $userCategory->categories_id = $data['category_id'];

        return $userCategory->save() ? $userCategory : false;
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

