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

    public function update(array $attributes, $id): void
    {
        $user = User::where('id', $id)->first();
        $user->update($attributes);
        $user->save();
    }

    public function delete($id): void
    {
        $user = User::where('id', $id)->first();
        $user->delete();
    }

    public function find($id)
    {
        return User::where('id', $id)->first();
    }
}
