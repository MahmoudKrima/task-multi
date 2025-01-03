<?php

namespace App\Services\Admin\WebSiteSettings;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    function getAll()
    {
        return Role::where('id', '!=', 1)
            ->orderBy('id', 'desc')
            ->paginate();
    }

    function filterRole($request)
    {
        $request->validated();
        return Role::where('name', 'LIKE', '%' . $request->input('name') . '%')
            ->where('id', '!=', 1)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    function getPermissions()
    {
        return Permission::get();
    }

    function storeRole($request)
    {
        $data = $request->validated();
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'admin']);
        $role->permissions()->sync($data['permission_id']);
    }

    function updateRole($request, $role)
    {
        $data = $request->validated();
        $role->update(['name' => $data['name'], 'guard_name' => 'admin']);
        $role->permissions()->sync($data['permission_id']);
    }
}
