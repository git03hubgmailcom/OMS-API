<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, String $user)
    {
        // get all cart items filtered by user id with menu
        //$cartItems = CartItem::where('user_id', $request->user_id)->with('menu')->get();
        //$cartItems = CartItem::where('user_id', $request->user_id)->get();

        // get all cart items with menu
        $cartItems = CartItem::where('user_id',$user)->with('menu')->get();
        return response()->json($cartItems, 200);
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
        // check if cart item exist
        $cartItem = CartItem::where('menu_id', $request->menu_id)->where('user_id', $request->user_id)->first();
        if ($cartItem) {
            // update cart item
            $cartItem->quantity = $request->quantity;
            $cartItem->total_price = $request->total_price;
            $cartItem->status = "Active";
            $cartItem->save();
            return response()->json([
                'message' => 'Cart item successfully updated.',
                'data' => $cartItem
            ], 200);
        }else{
            // create a new cart item
            $cartItem = new CartItem();
            $cartItem->menu_id = $request->menu_id;
            $cartItem->quantity = $request->quantity;
            $cartItem->user_id = $request->user_id;
            $cartItem->total_price = $request->total_price;
            $cartItem->status = "Active";
            $cartItem->save();
            return response()->json([
                'message' => 'Cart item successfully created.',
                'data' => $cartItem
            ], 201);
        }

        // create a new cart item
        /* $cartItem = new CartItem();
        $cartItem->menu_id = $request->menu_id;
        $cartItem->quantity = $request->quantity;
        $cartItem->user_id = $request->user_id;
        $cartItem->total_price = $request->total_price;
        $cartItem->status = "Active";
        $cartItem->save();
        return response()->json([
            'message' => 'Cart item successfully created.',
            'data' => $cartItem
        ], 201); */
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // update a cart item
        $cartItem->quantity = $request->quantity;
        $cartItem->total_price = $request->total_price;
        $cartItem->status = $request->status? $request->status : $cartItem->status;
        $cartItem->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        // delete a cart item
        $cartItem->delete();
        return response()->json([
            'message' => 'Cart item successfully deleted.'
        ], 200);
    }
}
