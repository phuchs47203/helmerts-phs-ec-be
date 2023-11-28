<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {
            $fiels = $request->validate([
                'total_payment' => 'required',
                'total_product_cost' => 'required',
                'cus_id' => 'required',
                'shipping_fee' => 'required',
                'note' => 'required|string',
                'phone_number' => 'required',
                'country' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'address_details' => 'required|string',
                'state' => 'required|string',
                'payment_status' => 'required|string',
                'confirm_by' => '',
                'update_by' => '',
                'shipper_id' => '',
                'est_arr_date' => '',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        $order = Order::create($request->all());
        $response = [
            'order' => $order
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Order::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return 'order not found';
        }
        $order->update($request->all());
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Order::destroy($id);
    }
}
