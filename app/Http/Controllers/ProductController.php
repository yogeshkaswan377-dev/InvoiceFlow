<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display listing of products
     */
    // app/Http/Controllers/ProductController.php

    public function index(Request $request)
    {
        $companyId = session('current_company_id') ?? auth()->user()->current_company_id;

        $query = Product::where('company_id', $companyId);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('hsn_sac_code', 'like', "%{$search}%");
            });
        }

        // GST Rate filter
        if ($request->filled('gst_rate')) {
            $query->where('gst_rate', $request->gst_rate);
        }

        $products = $query->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'hsn_sac_code' => 'nullable|string|max:8',
            'unit_price' => 'required|numeric|min:0',
            'gst_rate' => 'required|numeric|in:0,5,12,18,28',
            'unit' => 'nullable|string|max:20',
        ]);

        Product::create([
            'company_id' => Auth::user()->current_company_id,
            ...$validated
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'hsn_sac_code' => 'nullable|string|max:8',
            'unit_price' => 'required|numeric|min:0',
            'gst_rate' => 'required|numeric|in:0,5,12,18,28',
            'unit' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Search products (AJAX - for invoice builder)
     */
    public function search(Request $request)
    {
        $companyId = Auth::user()->current_company_id;

        $products = Product::forCompany($companyId)
            ->active()
            ->search($request->q)
            ->limit(10)
            ->get(['id', 'name', 'hsn_sac_code', 'unit_price', 'gst_rate']);

        return response()->json($products);
    }
}
