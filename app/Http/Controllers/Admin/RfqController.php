<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialInventory;
use App\Models\Rfq;
use App\Models\RfqMaterialItem;
use App\Models\MaterialStockLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
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
        $stockOutLogs = MaterialStockLog::query()
            ->with(['material', 'rfq', 'creator'])
            ->where('reference_type', 'rfq')
            ->where('movement_type', 'OUT')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.rfqs.index', compact('rfqs', 'stockOutLogs'));
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
        $actorId = $request->user()?->id;
        $newItems = $this->extractMaterialItems($request);

        DB::transaction(function () use ($rfq, $newItems, $actorId) {
            $previousItems = $rfq->materialItems()->get();

            // Rollback konsumsi sebelumnya agar update RFQ tidak mendobel pengurangan stok.
            foreach ($previousItems as $previousItem) {
                $material = MaterialInventory::query()
                    ->lockForUpdate()
                    ->find($previousItem->material_inventory_id);

                if (! $material) {
                    continue;
                }

                $before = (float) $material->current_stock;
                $after = $before + (float) $previousItem->qty_needed;
                $material->current_stock = $after;
                $material->updated_by = $actorId;
                $material->save();

                MaterialStockLog::create([
                    'material_inventory_id' => $material->id,
                    'rfq_id' => $rfq->id,
                    'movement_type' => 'IN',
                    'qty' => (float) $previousItem->qty_needed,
                    'stock_before' => $before,
                    'stock_after' => $after,
                    'reference_type' => 'rfq',
                    'reference_id' => $rfq->id,
                    'note' => 'Rollback stok material akibat update RFQ',
                    'created_by' => $actorId,
                ]);
            }

            $rfq->materialItems()->delete();

            foreach ($newItems as $item) {
                $material = MaterialInventory::query()
                    ->lockForUpdate()
                    ->find($item['material_inventory_id']);

                if (! $material) {
                    continue;
                }

                $qty = (float) $item['qty_needed'];
                $before = (float) $material->current_stock;
                $after = $before - $qty;

                if ($after < 0) {
                    throw ValidationException::withMessages([
                        'materials' => "Stok material {$material->name} tidak mencukupi untuk RFQ.",
                    ]);
                }

                $material->current_stock = $after;
                $material->updated_by = $actorId;
                $material->save();

                RfqMaterialItem::create([
                    'rfq_id' => $rfq->id,
                    'material_inventory_id' => $material->id,
                    'qty_needed' => $qty,
                    'estimated_cost' => $qty * (float) $material->unit_cost,
                ]);

                MaterialStockLog::create([
                    'material_inventory_id' => $material->id,
                    'rfq_id' => $rfq->id,
                    'movement_type' => 'OUT',
                    'qty' => $qty,
                    'stock_before' => $before,
                    'stock_after' => $after,
                    'reference_type' => 'rfq',
                    'reference_id' => $rfq->id,
                    'note' => 'Pengeluaran stok material dari RFQ',
                    'created_by' => $actorId,
                ]);
            }
        });
    }

    private function extractMaterialItems(Request $request): array
    {
        $rows = $request->input('materials', []);
        $bucket = [];

        foreach ($rows as $row) {
            $materialId = (int) ($row['material_inventory_id'] ?? 0);
            $qty = (float) ($row['qty_needed'] ?? 0);
            if ($materialId <= 0 || $qty <= 0) {
                continue;
            }
            if (! array_key_exists($materialId, $bucket)) {
                $bucket[$materialId] = 0;
            }
            $bucket[$materialId] += $qty;
        }

        $result = [];
        foreach ($bucket as $materialId => $qty) {
            $result[] = [
                'material_inventory_id' => $materialId,
                'qty_needed' => $qty,
            ];
        }

        return $result;
    }
}
