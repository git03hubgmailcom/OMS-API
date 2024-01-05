<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all menus
        $menus = Menu::all();
        return response()->json($menus, 200);
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
        // create a new menu
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->stock = $request->stock;
        $menu->price = $request->price;
        $menu->status = $request->status;
        $menu->save();
        return response()->json([
            'message' => 'Menu successfully created.',
            'data' => $menu
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        // get certain menu
        return response()->json($menu, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        // update a menu
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->stock = $request->stock;
        $menu->price = $request->price;
        $menu->status = $request->status;
        $menu->save();
        return response()->json([
            'message' => 'Menu successfully updated.',
            'data' => $menu
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // delete a menu
        $menu->delete();
        return response()->json([
            'message' => 'Menu successfully deleted.'
        ], 200);
    }
}
