<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $action = $request->route()->getActionMethod();
            $map = [
                'index' => 'role.view',
                'create' => 'role.create',
                'store' => 'role.create',
                'edit' => 'role.update',
                'update' => 'role.update',
                'destroy' => 'role.delete',
            ];
            if (isset($map[$action])) {
                Gate::authorize('permission', $map[$action]);
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $roles = Role::query()
            ->withCount(['permissions', 'users'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.settings.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = $this->permissionsGrouped();

        return view('admin.settings.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedRole($request, null);
        $data['is_active'] = $request->boolean('is_active');
        $permissionIds = $this->validatedPermissionIds($request);

        $role = Role::create($data);
        $role->permissions()->sync($permissionIds);

        return redirect()->route('admin.settings.roles.index')->with('status', 'Peran berhasil dibuat.');
    }

    public function edit(Role $role): View
    {
        $permissions = $this->permissionsGrouped();
        $role->load('permissions');
        $role->loadCount('users');

        return view('admin.settings.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $this->validatedRole($request, $role->id);
        $data['is_active'] = $request->boolean('is_active');

        if (in_array($role->code, ['super_admin', 'customer', 'admin', 'marketing'], true)) {
            $data['code'] = $role->code;
        }

        $permissionIds = $this->validatedPermissionIds($request);

        $role->update($data);
        $role->permissions()->sync($permissionIds);

        return redirect()->route('admin.settings.roles.index')->with('status', 'Peran dan izin diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if (in_array($role->code, ['super_admin', 'customer'], true)) {
            return redirect()->route('admin.settings.roles.index')->with('error', 'Peran sistem ini tidak dapat dihapus.');
        }

        if ($role->users()->exists()) {
            return redirect()->route('admin.settings.roles.index')->with('error', 'Tidak dapat menghapus peran yang masih dipakai pengguna.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.settings.roles.index')->with('status', 'Peran dihapus.');
    }

    /**
     * @return Collection<string, \Illuminate\Database\Eloquent\Collection<int, Permission>>
     */
    private function permissionsGrouped()
    {
        return Permission::query()
            ->where('is_active', true)
            ->orderBy('module')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('module');
    }

    private function validatedRole(Request $request, ?int $ignoreId): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-z][a-z0-9_]*$/',
                Rule::unique('roles', 'code')->ignore($ignoreId),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);
    }

    /**
     * @return array<int>
     */
    private function validatedPermissionIds(Request $request): array
    {
        $ids = $request->validate([
            'permission_ids' => ['nullable', 'array'],
            'permission_ids.*' => ['integer', 'exists:permissions,id'],
        ])['permission_ids'] ?? [];

        return array_values(array_unique(array_map('intval', $ids)));
    }
}
