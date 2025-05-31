<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
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
        'is_new_user',
        'enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public static function getAllUsers()
    {   
        return self::with('accounts')
                    ->select('id','name', 'last_name', 'email', 'rol_id', 'google_id', 'birth_date', 'username')
                    ->where('enabled', 1)
                    ->get();
    }

    public static function storeUser(array $data): bool
    {
        $user = new self();

        $user->name = $data['name'];
        $user->last_name = $data['last_name'] ?? null;
        $user->birth_date = $data['birth_date'] ?? null;
        $user->rol_id = $data['rol_id'];
        $user->email = $data['email'];
        $user->username = $data['username'] ?? null;
        $user->password = bcrypt($data['password']);

        return $user->save();
    }

    public static function deleteUser(int $id): bool
    {
        $user = self::find($id);

        if ($user) {
            $user->enabled = 0;
            return $user->save();
        }

        return false;
    }

    public static function getUserById(int $id): ?self
    {
        return self::where('id', $id)
            ->where('enabled', 1)
            ->first();
    }

    public static function updateUserInfoFromInitialSetup(Array $data): ?User
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

    public static function updateNewUser($user): bool{
        $user->isNewUser = false;
        if(!$user->save()){
            return false;
        }

        return true;
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'users_accounts', 'user_id', 'account_id');
    }

    public function personalCategories()
    {
        return $this->belongsToMany(Category::class, 'user_categories', 'user_id', 'categories_id');
    }

    public static function getPersonalCategoriesByUserId($id)
    {
        return self::find($id)?->personalCategories()
            ->with('icon')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'icon' => $category->icon?->icon 
                ];
            });
    }



}
