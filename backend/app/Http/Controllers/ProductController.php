<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user')->paginate(10);
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
        // try {
        //     DB::beginTransaction();
            $product = Product::create($request->all());
        //     DB::commit();

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['error' => 'Error al crear el producto', 'message'], 500);
        // }

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product->load('user'), 200);
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
        // try {
        //     DB::beginTransaction();
            $product->update($request->all());
        //     DB::commit();

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['error' => 'Error al actualizar el producto', 'message'], 500);
        // }

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // try {
        //     DB::beginTransaction();
            $product = Product::find($product->id);
            $product->delete();
        //     DB::commit();

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['error' => 'Error al eliminar el producto', 'message'], 500);
        // }

        return response()->json(null, 204);
    }
}
