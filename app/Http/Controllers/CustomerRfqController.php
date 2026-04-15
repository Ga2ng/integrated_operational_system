<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rfq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerRfqController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $rfqs = Rfq::query()
            ->where('client_user_id', $user->id)
            ->with('product')
            ->latest()
            ->paginate(15);

        return view('customer.rfqs.index', compact('rfqs'));
    }

    public function create(): View
    {
        $products = Product::query()->activeCatalog()->orderBy('name')->get();

        return view('customer.rfqs.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quoted_amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        Rfq::create([
            'client_user_id' => $user->id,
            'product_id' => $data['product_id'],
            'quoted_amount' => $data['quoted_amount'],
            'transaction_date' => $data['transaction_date'],
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        return redirect()->route('dashboard.rfqs.index')->with('status', 'Penawaran berhasil dikirim.');
    }

    public function show(Rfq $rfq): View
    {
        $this->authorizeRfq($rfq);

        $rfq->load('product');

        return view('customer.rfqs.show', compact('rfq'));
    }

    private function authorizeRfq(Rfq $rfq): void
    {
        if ($rfq->client_user_id !== auth()->id()) {
            abort(403);
        }
    }
}
