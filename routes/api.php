<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// group routes for user with prefix
Route::prefix('users')->group(function () {
    // get all users
    Route::get('/', 'App\Http\Controllers\UserController@index');
    // create a new user
    Route::post('/', 'App\Http\Controllers\UserController@store');
    // get a specific user
    Route::get('/{user}', 'App\Http\Controllers\UserController@show');
    // update a specific user
    Route::put('/{user}', 'App\Http\Controllers\UserController@update');
    // delete a specific user
    Route::delete('/{user}', 'App\Http\Controllers\UserController@destroy');
    // login
    Route::post('/login', 'App\Http\Controllers\UserController@login');
});

// group routes for menu with prefix
Route::prefix('menus')->middleware(['cors'])->group(function () {
    // get all menus
    Route::get('/', 'App\Http\Controllers\MenuController@index');
    // create a new menu
    Route::post('/', 'App\Http\Controllers\MenuController@store');
    // get a specific menu
    Route::get('/{menu}', 'App\Http\Controllers\MenuController@show');
    // update a specific menu
    Route::put('/{menu}', 'App\Http\Controllers\MenuController@update');
    // delete a specific menu
    Route::delete('/{menu}', 'App\Http\Controllers\MenuController@destroy');
});

// group routes for order with prefix
Route::prefix('orders')->middleware(['cors'])->group(function () {
    // get all orders
    Route::get('/', 'App\Http\Controllers\OrderController@index');
    // create a new order
    Route::post('/', 'App\Http\Controllers\OrderController@store');
    // get a specific order
    Route::get('/{order}', 'App\Http\Controllers\OrderController@show');
    // update a specific order
    Route::put('/{order}', 'App\Http\Controllers\OrderController@update');
    // delete a specific order
    Route::delete('/{order}', 'App\Http\Controllers\OrderController@destroy');
});


// group routes for cart item with prefix
Route::prefix('cart-items')->middleware(['cors'])->group(function () {
    // get all cart items
    Route::get('/', 'App\Http\Controllers\CartItemController@index');
    // create a new cart item
    Route::post('/', 'App\Http\Controllers\CartItemController@store');
    // get a specific cart item
    Route::get('/{cartItem}', 'App\Http\Controllers\CartItemController@show');
    // update a specific cart item
    Route::put('/{cartItem}', 'App\Http\Controllers\CartItemController@update');
    // delete a specific cart item
    Route::delete('/{cartItem}', 'App\Http\Controllers\CartItemController@destroy');
});

// group routes for collection with prefix
Route::prefix('collections')->middleware(['cors'])->group(function () {
    // get all collections
    Route::get('/', 'App\Http\Controllers\CollectionController@index');
    // create a new collection
    Route::post('/', 'App\Http\Controllers\CollectionController@store');
    // get a specific collection
    Route::get('/{collection}', 'App\Http\Controllers\CollectionController@show');
    // update a specific collection
    Route::put('/{collection}', 'App\Http\Controllers\CollectionController@update');
    // delete a specific collection
    Route::delete('/{collection}', 'App\Http\Controllers\CollectionController@destroy');

    // add order to collection
    Route::post('/{collection}/add-order/{order}', 'App\Http\Controllers\CollectionController@addOrderToCollection');

    // get collection item
    Route::get('/{collectionItem}/collection-item', 'App\Http\Controllers\CollectionController@getCollectionItem');

    // update collection item
    Route::put('/{collectionItem}/collection-item', 'App\Http\Controllers\CollectionController@updateCollectionItem');

    // delete a collection item
    Route::delete('/{collectionItem}/collection-item', 'App\Http\Controllers\CollectionController@deleteCollectionItem');
});