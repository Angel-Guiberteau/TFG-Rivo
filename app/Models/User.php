<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Models\UserCategory;
use App\Models\Category;
use App\Services\GoogleMailerService;

/**
 * Clase User
 *
 * Representa a un usuario del sistema.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos asignables masivamente.
     *
     * @var array<string>
     */
    protected $fillable = [
        'email',
        'password',
        'google_id',
        'name',
        'last_name',
        'username',
        'birth_date',
        'rol_id',
        'isNewUser',
        'enabled',
    ];

    /**
     * Atributos ocultos para serialización.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos con casteo de tipo.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Devuelve el usuario autenticado con relaciones cargadas.
     *
     * @return User|null
     */
    public static function getUser()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return $user->load([
            'accounts.objectives',
            'accounts.operations',
            'role',
        ]);
    }

    /**
     * Obtiene el número total de usuarios.
     *
     * @return int
     */
    public static function numberOfUsers(): int {
        return self::count();
    }

    /**
     * Relación con el rol del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Obtiene todos los usuarios activos.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllUsers()
    {
        return self::with('accounts')
            ->select('id','name', 'last_name', 'email', 'rol_id', 'google_id', 'birth_date', 'username', 'isNewUser')
            ->where('enabled', 1)
            ->get();
    }

    /**
     * Crea un nuevo usuario.
     *
     * @param UserController $data
     * @return bool
     */
    public static function storeUser(UserController $data): bool
    {
        $user = new self();

        $user->name = $data->name;
        $user->last_name = $data->last_name ?? null;
        $user->birth_date = $data->birth_date ?? null;
        $user->rol_id = $data->rol_id;
        $user->email = $data->email;
        $user->username = $data->username ?? null;
        $user->password = $data->password ?? null;
        $user->isNewUser = $data->newUser;

        return $user->save();
    }

    /**
     * Desactiva (elimina lógicamente) un usuario.
     *
     * @param int $id
     * @return bool
     */
    public static function deleteUser(int $id): bool
    {
        $user = self::find($id);

        if (!$user) {
            return false;
        }

        $user->enabled = 0;

        return $user->save();
    }

    /**
     * Obtiene un usuario por ID si está habilitado.
     *
     * @param int $id
     * @return self|null
     */
    public static function getUserById(int $id): ?self
    {
        return self::where('id', $id)
            ->where('enabled', 1)
            ->first();
    }

    /**
     * Actualiza los datos iniciales del usuario desde el setup inicial.
     *
     * @param array $data
     * @return User|null
     */
    public static function updateUserInfoFromInitialSetup(array $data): ?User
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->username = $data['username'];
        $user->birth_date = $data['birth_date'];

        return $user->save() ? $user : null;
    }

    /**
     * Marca el usuario como ya no nuevo.
     *
     * @param User $user
     * @return bool
     */
    public static function updateNewUser($user): bool
    {
        $user->isNewUser = false;
        return $user->save();
    }

    /**
     * Relación con cuentas del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'users_accounts', 'user_id', 'account_id');
    }

    /**
     * Obtiene categorías personales del usuario.
     *
     * @param int $id
     * @return \Illuminate\Support\Collection|null
     */
    public static function getPersonalCategoriesByUserId($id)
    {
        return self::find($id)?->personalCategories()
            ->where('categories.enabled', 1)
            ->with(['icon', 'movementTypes:id'])
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'icon' => $category->icon?->icon,
                    'movement_type_ids' => $category->movementTypes->pluck('id')->toArray()
                ];
            });
    }

    /**
     * Elimina (desactiva) una categoría personal.
     *
     * @param int $userId
     * @param int $categoryId
     * @return bool
     */
    public static function deletePersonalCategory(int $userId, int $categoryId): bool
    {
        DB::beginTransaction();

        try {
            $deletedCategory = Category::where('id', $categoryId)->update(['enabled' => 0]);

            if (!$deletedCategory) {
                DB::rollBack();
                return false;
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Actualiza una categoría personal del usuario.
     *
     * @param int $userId
     * @param int $categoryId
     * @param string $newName
     * @param string $iconHtml
     * @return bool
     */
    public static function updatePersonalCategory(int $userId, int $categoryId, string $newName, string $iconHtml): bool
    {
        DB::beginTransaction();

        try {
            $category = Category::find($categoryId);
            if (!$category) {
                DB::rollBack();
                return false;
            }

            $isLinked = UserCategory::where('user_id', $userId)
                ->where('categories_id', $categoryId)
                ->exists();

            if (!$isLinked) {
                DB::rollBack();
                return false;
            }

            $icon = Icon::where('icon', $iconHtml)->first();
            if (!$icon) {
                DB::rollBack();
                return false;
            }

            $hasChanges = false;

            if ($category->name !== $newName) {
                $category->name = $newName;
                $hasChanges = true;
            }

            if ($category->icon_id !== $icon->id) {
                $category->icon_id = $icon->id;
                $hasChanges = true;
            }

            if ($hasChanges && !$category->save()) {
                DB::rollBack();
                return false;
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Crea una nueva categoría personal para el usuario.
     *
     * @param int $userId
     * @param string $name
     * @param string $iconHtml
     * @return int|false
     */
    public static function addPersonalCategory(int $userId, string $name, string $iconHtml): int|false
    {
        DB::beginTransaction();

        try {
            $icon = Icon::where('icon', $iconHtml)->first();
            if (!$icon) {
                DB::rollBack();
                return false;
            }

            $category = new Category();
            $category->name = $name;
            $category->icon_id = $icon->id;

            if (!$category->save()) {
                DB::rollBack();
                return false;
            }

            $userCategory = new UserCategory();
            $userCategory->user_id = $userId;
            $userCategory->categories_id = $category->id;

            if (!$userCategory->save()) {
                DB::rollBack();
                return false;
            }

            DB::commit();
            return $category->id;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Relación con las categorías personales del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personalCategories()
    {
        return $this->belongsToMany(Category::class, 'user_categories', 'user_id', 'categories_id');
    }


    public function sendPasswordResetNotification($token)
    {
        $url = url("/reset-password/{$token}") . '?email=' . urlencode($this->email);

        $html = view('emails.custom-reset-password', ['url' => $url])->render();

        $mailer = app(GoogleMailerService::class);

        $mailer->send($this->email, 'Restablece tu contraseña', $html);
    }



}
