<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'balance',
        'currency',
        'enabled',
    ];

    public static function addAccount(Array $data): bool | self{

        $account = new self;

        $account->name = $data['account_name'];

        return $account->save() ? $account : false;
    }
}
