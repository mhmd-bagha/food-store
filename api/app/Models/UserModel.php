<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['first_name', 'last_name', 'phone_number', 'email', 'password', 'image', 'create_at', 'update_at'];
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    public function signup($data)
    {
        $existUser = UserModel::where('email', $data['email'])->exists();
        // the check exist user then return callback false/create user
        return (!$existUser) ? UserModel::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'create_at' => now(),
            'update_at' => null
        ]) : false;
    }
}