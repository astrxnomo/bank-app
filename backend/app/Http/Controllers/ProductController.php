<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    private const CACHE_TTL_SECONDS = 300;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = (int) $request->query('page', 1);
        $version = (int) Cache::get('products:version', 1);
        $cacheKey = "products:index:v{$version}:page:{$page}";

        $products = Cache::remember(
            $cacheKey,
            self::CACHE_TTL_SECONDS,
            fn () => Product::with('user')->paginate(10)
        );

        return response()->json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'type' => ['required', 'string', 'max:255'],
            'time' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric'],
            'interest' => ['required', 'numeric'],
        ]);

        $product = Product::create($validated);
        $this->clearProductsCache();

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $version = (int) Cache::get('products:version', 1);

        $cachedProduct = Cache::remember(
            "products:show:v{$version}:{$product->id}",
            self::CACHE_TTL_SECONDS,
            fn () => Product::with('user')->findOrFail($product->id)
        );

        return response()->json($cachedProduct, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
            'type' => ['sometimes', 'required', 'string', 'max:255'],
            'time' => ['sometimes', 'required', 'string', 'max:255'],
            'value' => ['sometimes', 'required', 'numeric'],
            'interest' => ['sometimes', 'required', 'numeric'],
        ]);

        $product->update($validated);
        $this->clearProductsCache();

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $this->clearProductsCache();

        return response()->json(null, 204);
    }

    private function clearProductsCache(): void
    {
        $nextVersion = ((int) Cache::get('products:version', 1)) + 1;
        Cache::forever('products:version', $nextVersion);
    }
}
