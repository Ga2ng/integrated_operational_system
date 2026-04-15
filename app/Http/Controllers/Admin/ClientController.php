<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $action = $request->route()->getActionMethod();
            $map = [
                'index' => 'client.view',
                'edit' => 'client.update',
                'update' => 'client.update',
            ];
            if (isset($map[$action])) {
                Gate::authorize('permission', $map[$action]);
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $customerRole = Role::where('code', 'customer')->first();

        $clients = User::query()
            ->when($customerRole, fn ($q) => $q->where('role_id', $customerRole->id))
            ->with('clientProfile')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    public function edit(User $client): View
    {
        $this->ensureCustomer($client);

        $client->load('clientProfile');

        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, User $client): RedirectResponse
    {
        $this->ensureCustomer($client);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'in:individu,korporat,internal'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $client->update(['name' => $data['name']]);

        $profile = $client->clientProfile;
        $payload = [
            'phone' => $data['phone'],
            'address' => $data['address'],
            'company_name' => $data['company_name'],
            'category' => $data['category'],
            'status' => $data['status'],
            'updated_by' => $request->user()->id,
        ];

        if ($profile) {
            $profile->update($payload);
        } else {
            $client->clientProfile()->create(array_merge($payload, [
                'created_by' => $request->user()->id,
            ]));
        }

        return redirect()->route('admin.clients.index')->with('status', 'Data klien diperbarui.');
    }

    private function ensureCustomer(User $user): void
    {
        $customerRole = Role::where('code', 'customer')->first();
        if (! $customerRole || $user->role_id !== $customerRole->id) {
            abort(404);
        }
    }
}
