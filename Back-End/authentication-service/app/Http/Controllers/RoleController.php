<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function createRole(Request $request): JsonResponse
    {
        $role = Role::create(['name' => $request->name]);
        return response()->json($role, 201);
    }
    public function assignRole(Request $request, User $user, Role $role): JsonResponse
    {
        $user->roles()->attach($role);
        return response()->json(['message' => 'Role assigned']);
    }
    public function removeRole(Request $request, User $user, Role $role): JsonResponse
    {
        $user->roles()->detach($role);
        return response()->json(['message' => 'Role removed']);
    }
    public function getUserRoles(User $user): JsonResponse
    {
        return response()->json($user->roles);
    }
}
