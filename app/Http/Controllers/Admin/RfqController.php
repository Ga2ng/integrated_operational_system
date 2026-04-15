<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rfq;
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
        $rfqs = Rfq::query()->with(['client', 'product'])->latest()->paginate(15);

        return view('admin.rfqs.index', compact('rfqs'));
    }

    public function create(): View
    {
        $clients = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        $products = Product::query()->orderBy('name')->get();

        return view('admin.rfqs.create', compact('clients', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        Rfq::create($data);

        return redirect()->route('admin.rfqs.index')->with('status', 'RFQ dibuat.');
    }

    public function edit(Rfq $rfq): View
    {
        $clients = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        $products = Product::query()->orderBy('name')->get();

        return view('admin.rfqs.edit', compact('rfq', 'clients', 'products'));
    }

    public function update(Request $request, Rfq $rfq): RedirectResponse
    {
        $data = $this->validated($request);
        $data['updated_by'] = $request->user()->id;

        $rfq->update($data);

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
            'product_id' => ['required', 'exists:products,id'],
            'quoted_amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,approved,closed'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
