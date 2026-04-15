<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialInventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InventoryMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $action = $request->route()->getActionMethod();
            $map = [
                'index' => 'inventory.view',
                'create' => 'inventory.create',
                'store' => 'inventory.create',
                'edit' => 'inventory.update',
                'update' => 'inventory.update',
                'destroy' => 'inventory.delete',
            ];
            if (isset($map[$action])) {
                Gate::authorize('permission', $map[$action]);
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $materials = MaterialInventory::query()->latest()->paginate(15);

        return view('admin.inventory-materials.index', compact('materials'));
    }

    public function create(): View
    {
        return view('admin.inventory-materials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        MaterialInventory::create($data);

        return redirect()->route('admin.inventory-materials.index')->with('status', 'Material inventory dibuat.');
    }

    public function edit(MaterialInventory $materialInventory): View
    {
        return view('admin.inventory-materials.edit', ['material' => $materialInventory]);
    }

    public function update(Request $request, MaterialInventory $materialInventory): RedirectResponse
    {
        $data = $this->validated($request, $materialInventory->id);
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = $request->user()->id;

        $materialInventory->update($data);

        return redirect()->route('admin.inventory-materials.index')->with('status', 'Material inventory diperbarui.');
    }

    public function destroy(MaterialInventory $materialInventory): RedirectResponse
    {
        if ($materialInventory->rfqItems()->exists()) {
            return redirect()->route('admin.inventory-materials.index')->with('error', 'Material sudah dipakai pada RFQ.');
        }

        $materialInventory->delete();

        return redirect()->route('admin.inventory-materials.index')->with('status', 'Material inventory dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('material_inventories', 'code')->ignore($ignoreId)],
            'name' => ['required', 'string', 'max:255'],
            'specification' => ['nullable', 'string'],
            'uom' => ['required', 'string', 'max:50'],
            'current_stock' => ['required', 'numeric', 'min:0'],
            'minimum_stock' => ['required', 'numeric', 'min:0'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
