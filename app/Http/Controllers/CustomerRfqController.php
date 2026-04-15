<?php

namespace App\Http\Controllers;

use App\Models\Rfq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerRfqController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        abort_if($user === null, 403);

        $rfqs = Rfq::query()
            ->where('client_user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('customer.rfqs.index', compact('rfqs'));
    }

    public function create(): View
    {
        return view('customer.rfqs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if($user === null, 403);

        $data = $request->validate([
            'request_title' => ['required', 'string', 'max:255'],
            'quoted_amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        Rfq::create([
            'client_user_id' => $user->id,
            'request_title' => $data['request_title'],
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

        return view('customer.rfqs.show', compact('rfq'));
    }

    private function authorizeRfq(Rfq $rfq): void
    {
        if ($rfq->client_user_id !== Auth::id()) {
            abort(403);
        }
    }
}
