<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_details;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order_details::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $fields = $request->validate([
                'order_id' => 'required',
                'product_id' => 'required',
                'note' => '',
                'amount' => 'required',
                'sale_price' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        $order_details = Order_details::create([
            'order_id' => $fields['order_id'],
            'product_id' => $fields['product_id'],
            'note' => $fields['note'],
            'amount' => $fields['amount'],
            'sale_price' => $fields['sale_price']
        ]);
        $response = [
            'order_details' => $order_details
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Order_details::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order_details = Order_details::find($id);
        $order_details->update($request->all());
        return $order_details;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Order_details::destroy($id);
    }
}
