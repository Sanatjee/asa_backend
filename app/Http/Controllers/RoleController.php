<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Role::orderBy('name')->get()
        ]);
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return response()->json([
            'success' => true,
            'data' => [
                'role' => $role,
                'permissions' => Permission::orderBy('name')->get(),
                'assigned_permissions' => $role
                    ->permissions
                    ->pluck('name')
            ]
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->syncPermissions(
            $request->permissions
        );

        return response()->json([
            'success' => true,
            'message' => 'Permissions updated successfully.'
        ]);
    }
}