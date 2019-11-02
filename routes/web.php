<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Model\Client;
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

Route::post('/create/user', function(Request $request)
{
    $input = $request->all();
    $client = new Client($input);

    if($client->isValid()){
        $message = $client->getMessage();
        $client->save();
        return response()->json(['success' => $message], 200);
    }
    
    return response()->json(['error' => $client->getMessage()], 422);
    
});


