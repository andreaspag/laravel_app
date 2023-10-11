<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductsController;
use \App\Http\Controllers\TagsController;

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

Route::get('/v1/product', [ProductsController::class, 'all']);
Route::post('/v1/product/update', [ProductsController::class, 'update']);
Route::post('/v1/product', [ProductsController::class, 'create']);
Route::get('/v1/tag', [TagsController::class, 'all']);

