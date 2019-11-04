<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Model\Client;
use App\Model\Item;
use App\Model\Order;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function()
{
    return 'Hello World';
});

Route::prefix('create')->group(function () {
    
    /*
    * Route to create a new user
    */
    Route::post('user', function(Request $request) {
        $input = $request->all();
        $client = new Client($input);

        if($client->isValid()){
            $message = $client->getMessage();
            $client->save();
            return response()->json(['success' => $message], 200);
        }
        
        return response()->json(['error' => $client->getMessage()], 422);
    });

    /*
    * Route to create a new Item
    */

    Route::post('item', function(Request $request)
    {
        $input = $request->all();
        $item = new Item($input);

        if($item->isValid()){
            $message = $item->getMessage();
            $item->save();
            return response()->json(['success' => $message], 200);
        }

        return response()->json(['error' => $item->getMessage()], 422);
    });

    /*
    * Route to create a new order
    */

    Route::post('order', function(Request $request)
    {
        $input = $request->all();
        $order = new Order();
        
        $order->client_id = $input['client_id'];
        $order->status = 0;
        $order->order_code = md5(date('Y-m-d h:m:s'));

        $order->save();

        return response()->json(['order_id' => $order->id, 'order_code' => $order->order_code], 422);
    });
    

});

Route::prefix('order')->group(function () { 
    Route::post('add/item', function(Request $request)
    {
        $input = $request->all();
        $order_id = $input['order_id'];
        $item_id = $input['item_id'];


        $order = Order::where('id', $order_id)->first();
        $order->addItem($item_id);
        return response()->json(['success' => "Item adicionado com sucesso"], 200);
    });

    Route::post('remove/item', function(Request $request)
    {
        $input = $request->all();
        $order_id = $input['order_id'];
        $item_id = $input['item_id'];


        $order = Order::where('id', $order_id)->first();
        $order->removeItem($item_id);
        return response()->json(['success' => "Item removido com sucesso"], 200);
    });
});





