<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Order::all();
        $order = Order::query();
        return $order->orderBy('created_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {
            $fields = $request->validate([
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
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        $now = Carbon::now();
        $newDate = $now->addDays(5);
        $newDateString = $newDate->toDateString();
        $order = Order::create([
            'total_payment' => $fields['total_payment'],
            'total_product_cost' => $fields['total_product_cost'],
            'cus_id' => $fields['cus_id'],
            'shipping_fee' => $fields['shipping_fee'],
            'note' => $fields['note'],
            'phone_number' => $fields['phone_number'],
            'country' => $fields['country'],
            'city' => $fields['city'],
            'district' => $fields['district'],
            'address_details' => $fields['address_details'],
            'status' => 'Pending',
            'payment_status' => 'Not Paid',
            'confirm_by' => null,
            'update_by' => null,
            'shipper_id' => null,
            'est_arr_date' => $newDateString,
        ]);
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

    public function showOrderUser(string $id)
    {
        $user = User::find($id);
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        return $orders;
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
