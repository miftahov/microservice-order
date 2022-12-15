<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbacController;
use App\Http\Controllers\ExampleController;

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

Route::get('/abac', [AbacController::class, 'index']);
Route::get('/example', [ExampleController::class, 'index']);
Route::get('/example/order/command/cancel', [ExampleController::class, 'commandOrderCancel']);
Route::get('/example/order/command/create', [ExampleController::class, 'сommandOrderCreate']);
Route::get('/example/order/command/update', [ExampleController::class, 'сommandOrderUpdate']);
Route::get('/example/order/event/created', [ExampleController::class, 'eventOrderCreated']);
Route::get('/example/order/event/deleted', [ExampleController::class, 'eventOrderDeleted']);
Route::get('/example/order/event/updated', [ExampleController::class, 'eventOrderUpdated']);
Route::get('/example/order/query/order', [ExampleController::class, 'queryOrder']);

Route::get('/example/order/create', [ExampleController::class, 'orderCreate']);
