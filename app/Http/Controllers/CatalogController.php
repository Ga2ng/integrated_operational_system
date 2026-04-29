<?php

namespace App\Http\Controllers;

use App\Models\MaterialInventory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $query = MaterialInventory::where('is_active', true);

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('specification', 'like', "%{$search}%");
            });
        }

        $materials = $query->orderBy('name')->paginate(12)->withQueryString();

        return view('site.catalog', compact('materials', 'search'));
    }

    public function show(MaterialInventory $materialInventory): View
    {
        abort_unless($materialInventory->is_active, 404);

        return view('site.catalog-detail', ['material' => $materialInventory]);
    }
}
