<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $action = $request->route()->getActionMethod();
            $map = [
                'index' => 'product.view',
                'show' => 'product.view',
                'create' => 'product.create',
                'store' => 'product.create',
                'edit' => 'product.update',
                'update' => 'product.update',
                'destroy' => 'product.delete',
            ];
            if (isset($map[$action])) {
                Gate::authorize('permission', $map[$action]);
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $products = Product::query()->orderBy('name')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Produk disimpan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = $request->user()->id;

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Produk diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->rfqs()->exists()) {
            return redirect()->route('admin.products.index')->with('error', 'Produk masih dipakai di RFQ.');
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Produk dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'unit' => ['required', 'string', 'max:50'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'availability_status' => ['required', 'in:available,out_of_stock'],
        ]);
    }
}
