<?php

use App\Http\Controllers\GetShopsWithProductsController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\ShowShopWithProductsController;
use App\Http\Controllers\StoreShopWithProductsController;
use App\Http\Controllers\UpdateShopController;
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

Route::get('/shops', GetShopsWithProductsController::class)->name('shop.index');
Route::get('/shop/{id}', ShowShopWithProductsController::class)->name('shop.show');
Route::post('/shop', StoreShopWithProductsController::class)->name('shop.store');
Route::put('/shop', UpdateShopController::class)->name('shop.update');
Route::post('/shopping', ShoppingController::class)->name('shopping');

