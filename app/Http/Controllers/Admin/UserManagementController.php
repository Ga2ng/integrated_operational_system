<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_unless($request->user()?->isSuperAdmin(), 403);

            return $next($request);
        });
    }

    public function index(): View
    {
        $users = User::query()
            ->with('role')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.settings.users.index', compact('users'));
    }

    public function edit(User $user): View
    {
        $roles = Role::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.settings.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $payload = ['role_id' => (int) $validated['role_id']];

        if (! empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $user->update($payload);

        return redirect()
            ->route('admin.settings.users.index')
            ->with('status', 'Pengguna berhasil diperbarui.');
    }
}
