<?php

namespace App\Http\Controllers\Admin\WebSiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\SearchRoleRequest;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Services\Admin\WebSiteSettings\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService)
    {
    }

    public function index()
    {
        $roles = $this->roleService->getAll();
        return view('dashboard.pages.role.index', compact('roles'));
    }

    public function search(SearchRoleRequest $request)
    {
        $roles = $this->roleService->filterRole($request);
        return view('dashboard.pages.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getPermissions();
        return view('dashboard.pages.role.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->storeRole($request);
        return back()
            ->with('Success', __('admin.created_successfully'));
    }

    public function edit(Role $role)
    {
        if ($role && $role->id == 1) {
            return back()
                ->with('Error', __('admin.not_found_data'));
        }
        $permissions = $this->roleService->getPermissions();
        return view('dashboard.pages.role.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        if ($role && $role->id == 1) {
            return back()
                ->with('Error', __('admin.not_found_data'));
        }
        $this->roleService->updateRole($request, $role);
        return back()
            ->with('Success', __('admin.updated_successfully'));
    }
}
