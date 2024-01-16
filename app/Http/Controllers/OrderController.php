<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\CartItem;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all orders with related user
        $orders = Order::with('user')->with('orderItems')->get();
        return response()->json($orders, 200);
        
    }

    public function getOrdersOfAUser(String $user)
    {
        // get all orders of logged user
        $orders = Order::where('user_id', $user)->with('user')->with('orderItems')->get();
        return response()->json($orders, 200);
        
    }
    /* {
        $user = auth()->user();
        return response()->json($user, 200);
        // get all orders of logged user
        $orders = Order::where('user_id', $user)->with('user')->with('orderItems')->get();
        return response()->json($orders, 200);
        
    } */

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
        // create a new order
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->date_ordered = $request->created_dateTime;
        $order->date_claimed = $request->claimed_dateTime;
        $order->date_paid = $request->payment_dateTime;
        $order->total_price = $request->total_price;
        $order->status = $request->status;
        $order->payment_method = $request->payment_method;

        $order->save();

        foreach ($request->items as $key => $value) {
            $order_items = new OrderItem();
            $order_items->order_id = $order->id;
            $order_items->menu_id = $value['menu']['id'];
            $order_items->quantity = $value['quantity'];
            $order_items->total_price = $value['total_price'];
            $order_items->status = $request->status;
            $order_items->save();

            $cart_item = CartItem::find($value['id']);
            $cart_item->delete();
        }

        if($request->status=="paid"){
            $order->id;
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->date_paid = $request->payment_dateTime;
            $payment->total_price = $request->total_price;
            $payment->status = $request->status;
            $payment->method = $request->payment_method;
            $payment->reference_number = $request->payment_reference_number;
    
            $payment->save();
        }
        


        return response()->json([
            'message' => 'Order successfully created.',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // get certain order
        //return response()->json($order, 200);
        //return response()->json($order, 200);

        $orderWithItems = $order->load('orderItems')->load('user')->load('payments');
        
        // Return the data in a JSON response
        return response()->json($orderWithItems, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // update an order
        $order->date_claimed = $request->date_claimed? $request->date_claimed : $order->date_claimed;
        $order->date_paid = $request->date_paid? $request->date_paid : $order->date_paid;
        $order->total_price = $request->total_price? $request->total_price : $order->total_price;
        $order->status = $request->status? $request->status : $order->status;
        $order->payment_method = $request->payment_method? $request->payment_method : $order->payment_method;
        $order->save();
        return response()->json([
            'message' => 'Order successfully updated.',
            'data' => $order
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // delete an order
        $order->delete();
        return response()->json([
            'message' => 'Order successfully deleted.'
        ], 200);
    }
}
