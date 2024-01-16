<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CollectionItem;

class CollectionController extends Controller
{

    public function removeOrderToCollection(Collection $collection, Order $order, Request $request){
        $collectionItem = CollectionItem::where('collection_id', $collection->id)->where('order_id', $order->id)->first();
        $collectionItem->delete();

        $collection->total_price = $collection->total_price - $order->total_price;
        if(floatval($collection->total_price) < 0){
            $collection->total_price = 0;
        }
        $collection->save();

        return response()->json([
            'success' => true,
            'data' => $collectionItem
        ]);
    }

    public function addOrderToCollection(Collection $collection, Order $order, Request $request)
    {
        // get collection
        /* $collection = Collection::find($request->collection_id);
        // get order
        $order = Order::find($request->order_id);
        // add order to collection
        $collection->collectionItems()->attach($order);
        return response()->json([
            'success' => true,
            'data' => $collection
        ]); */
        /* return response()->json([
            'success' => true,
            'data' => $collection,
            'data2' => $order,
            'data3' => $request
        ]); */
        $newCollectionitem = new CollectionItem();
        $newCollectionitem->collection_id = $collection->id;
        $newCollectionitem->order_id = $order->id;
        $newCollectionitem->status = "paid";
        $newCollectionitem->save();

        $collection->total_price = $collection->total_price + $order->total_price;
        $collection->save();
        
        return response()->json([
            'success' => true,
            'data' => $newCollectionitem
        ]);
    }



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all collections of user_id = $request->user()->id
        $collections = Collection::get();
        return response()->json($collections);
    }

    public function getCollectionsOfAUser(Request $request, String $user)
    {
        // get all collections of user_id = $request->user()->id
        $collections = Collection::where('user_id', $user)->get();
        return response()->json($collections);
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
        // create new collection
        $collection = new Collection();
        $collection->user_id = $request->user_id;
        $collection->date_created = now();
        $collection->total_price = 0;
        $collection->save();
        return response()->json([
            'success' => true,
            'data' => $collection
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        // get collection
        //return response()->json($collection);

        $collectionWithItems = $collection->load('collectionItems.order.user');
        
        // Return the data in a JSON response
        return response()->json($collectionWithItems, 200);
    }

    public function getCollectionItem(CollectionItem $collectionItem)
    {
        // get collection
        //return response()->json($collection);

        $collectionItemWithItems = $collectionItem->load('order.orderItems.menu', 'order.user', 'order.payments');
        
        // Return the data in a JSON response
        return response()->json($collectionItemWithItems, 200);
    }

    public function updateCollectionItem(CollectionItem $collectionItem, Request $request)
    {
        // get collection
        //return response()->json($collection);

        $collectionItem->status = $request->status? $request->status : $collectionItem->status;
        $collectionItem->date_updated = now();
        $collectionItem->save();
        
        // Return the data in a JSON response
        return response()->json($collectionItem, 200);
    }

    public function deleteCollectionItem(CollectionItem $collectionItem)
    {
        // get collection
        //return response()->json($collection);

        $collectionItem->delete();
        
        // Return the data in a JSON response
        return response()->json($collectionItem, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $collectionItems = CollectionItem::where('collection_id', $collection->id)->get();
        foreach($collectionItems as $collectionItem){
            $collectionItem->status = $request->status? $request->status : $collectionItem->status;
            $collectionItem->save();

            $order = Order::find($collectionItem->order_id);
            $order->status = $request->status? $request->status : $order->status;
            $order->save();

        }



        // update collection
        $collection->status = $request->status? $request->status : $collection->status;
        $collection->total_price = $request->total_price? $request->total_price : $collection->total_price;
        $collection->save();
        return response()->json([
            'success' => true,
            'data' => $collection
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        // delete collection
        CollectionItem::where('collection_id', $collection->id)->delete();
        $collection->delete();
        return response()->json([
            'success' => true,
            'data' => $collection
        ]);

    }
}
