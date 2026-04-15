<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->activeCatalog()
            ->orderBy('name')
            ->get();

        return view('site.catalog', compact('products'));
    }
}
