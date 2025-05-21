<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'name',
        'email',
        'password',
        'google_id',
        'rol_id',
        'last_name',
        'birth_date',
        'username',
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public static function getAllUsers()
    {
        $users = new self();
        
        return $users->select('id','name', 'last_name', 'email', 'rol_id', 'google_id', 'birth_date', 'username')
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

}
