<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialInventory;
use App\Models\Rfq;
use App\Models\RfqMaterialItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class RfqController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $action = $request->route()->getActionMethod();
            $map = [
                'index' => 'rfq.view',
                'create' => 'rfq.create',
                'store' => 'rfq.create',
                'edit' => 'rfq.update',
                'update' => 'rfq.update',
                'destroy' => 'rfq.delete',
            ];
            if (isset($map[$action])) {
                Gate::authorize('permission', $map[$action]);
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $rfqs = Rfq::query()->with('client')->withCount('materialItems')->latest()->paginate(15);

        return view('admin.rfqs.index', compact('rfqs'));
    }

    public function create(): View
    {
        $clients = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        $materials = MaterialInventory::query()->where('is_active', true)->orderBy('name')->get();

        return view('admin.rfqs.create', compact('clients', 'materials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $rfq = Rfq::create($data);
        $this->syncMaterialItems($request, $rfq);

        return redirect()->route('admin.rfqs.index')->with('status', 'RFQ dibuat.');
    }

    public function edit(Rfq $rfq): View
    {
        $clients = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        $materials = MaterialInventory::query()->where('is_active', true)->orderBy('name')->get();
        $rfq->load('materialItems');

        return view('admin.rfqs.edit', compact('rfq', 'clients', 'materials'));
    }

    public function update(Request $request, Rfq $rfq): RedirectResponse
    {
        $data = $this->validated($request);
        $data['updated_by'] = $request->user()->id;

        $rfq->update($data);
        $this->syncMaterialItems($request, $rfq);

        return redirect()->route('admin.rfqs.index')->with('status', 'RFQ diperbarui.');
    }

    public function destroy(Rfq $rfq): RedirectResponse
    {
        $rfq->delete();

        return redirect()->route('admin.rfqs.index')->with('status', 'RFQ dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_user_id' => ['required', 'exists:users,id'],
            'request_title' => ['required', 'string', 'max:255'],
            'quoted_amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,approved,closed'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function syncMaterialItems(Request $request, Rfq $rfq): void
    {
        $rows = $request->input('materials', []);
        $validated = [];
        foreach ($rows as $row) {
            $materialId = (int) ($row['material_inventory_id'] ?? 0);
            $qty = (float) ($row['qty_needed'] ?? 0);
            if ($materialId <= 0 || $qty <= 0) {
                continue;
            }
            $material = MaterialInventory::query()->find($materialId);
            if (! $material) {
                continue;
            }
            $validated[] = [
                'material_inventory_id' => $materialId,
                'qty_needed' => $qty,
                'estimated_cost' => $qty * (float) $material->unit_cost,
            ];
        }

        $rfq->materialItems()->delete();
        foreach ($validated as $item) {
            RfqMaterialItem::create(array_merge($item, ['rfq_id' => $rfq->id]));
        }
    }
}
