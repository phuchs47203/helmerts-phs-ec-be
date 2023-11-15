<?php

namespace App\Http\Controllers;

use App\Models\Product_category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product_category::all();
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }

        // $fields = $request->validate([
        //     'name' => 'required|string',
        //     'description' => 'required|string',
        // ]);


        $category = Product_category::create([
            'name' => $fields['name'],
            'description' => $fields['description']
        ]);


        return response($category, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product_category::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category =  Product_category::find($id);
        $category->update($request->all());
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Product_category::destroy($id);
    }
}
