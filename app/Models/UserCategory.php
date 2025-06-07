<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase UserCategory
 *
 * Representa la relación entre usuarios y sus categorías personalizadas.
 */
class UserCategory extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'user_categories';

    /**
     * Atributos asignables masivamente.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'categories_id',
    ];

    /**
     * Indica si el modelo debe mantener las marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Añade una relación entre un usuario y una categoría.
     *
     * @param array $data
     * @return bool|self
     */
    public static function addUserCategory(array $data): bool | self
    {
        $userCategory = new self;

        $userCategory->user_id = $data['user_id'];
        $userCategory->categories_id = $data['category_id'];

        return $userCategory->save() ? $userCategory : false;
    }

    /**
     * Relación con el modelo Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    /**
     * Relación con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
