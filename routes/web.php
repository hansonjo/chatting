<?php

use Illuminate\Support\Facades\Route;
use App\Events\Message;
use App\Events\MyEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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


Route::get('/', function () {
    return view('welcome');
});


Route::post('/send-message', function (Request $request){
    event(
        new Message(
            $request->username, 
            $request->message
        )
    );
    return ['success' => true];
})->name('send-message');