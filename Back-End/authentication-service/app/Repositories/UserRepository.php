<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{

    public function create(array $attributes)
    {
        return User::create([
            'id' => Str::uuid(),
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
        ]);
    }

    public function update(array $attributes, $id)
    {

    }

    public function delete($id)
    {

    }

    public function find($id)
    {

    }

}
