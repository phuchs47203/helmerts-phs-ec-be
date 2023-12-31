<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_details;
use App\Models\Product;
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
                'sale_price' => 'required',
                'size_name' => 'required|string',
                'size_id' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        $order_details = Order_details::create([
            'order_id' => $fields['order_id'],
            'product_id' => $fields['product_id'],
            'note' => $fields['note'],
            'amount' => $fields['amount'],
            'sale_price' => $fields['sale_price'],
            'size_name' => $fields['size_name'],
            'size_id' => $fields['size_id'],
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

    public function showOrderDetails(string $id)
    {
        $order = Order::find($id);
        $order_details = $order->detailsOrder()->get();
        $listOrderDetails = [];
        foreach ($order_details as $key) {
            $product = Product::find($key['product_id']);
            $listOrderDetails[] = [
                'imgurl' => $product['imgurl'],
                'name' => $product['name'],
                'color' => $product['color'],
                'quantity' => $key['amount'],
                'sale_price' => $key['sale_price'],
                'size_name' => $key['size_name'],
                'size_id' => $key['size_id'],
                'id' => $key['id'],
                'order_id' => $key['order_id'],
                'product_id' => $key['product_id'],

            ];
        }
        return $listOrderDetails;
        // return response()->json($listOrderDetails);

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
