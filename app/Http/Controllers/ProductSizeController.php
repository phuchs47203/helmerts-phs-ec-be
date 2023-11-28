<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_size;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product_size::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'product_id' => 'required|string',
                'size' => 'required|string',
                'available' => 'required',
                'sold' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        $product_size = Product_size::create([
            'product_id' => $fields['product_id'],
            'size' => $fields['size'],
            'available' => $fields['available'],
            'sold' => $fields['sold'],
        ]);
        return response($product_size, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product_size::find($id);
    }

    //chơ table size of product
    public function showProductSize(string $id)
    {
        $product = Product::find($id);
        return $product->productSize;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product_size = Product_size::find($id);
        if (!$product_size) {
            return 'product_size not found';
        }
        $product_size->update($request->all());

        $available = 0;
        $sold = 0;
        $product_size_list = Product_size::query()->where('product_id', $product_size->product_id)->get();
        foreach ($product_size_list as $i) {
            $available += $i->available;
            $sold += $i->sold;
        }
        $product = Product::query()
            ->where('id', '=', $product_size->product_id)
            ->update([
                'available' => $available,
                'sold' => $sold,
            ]);
        return $product_size;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
