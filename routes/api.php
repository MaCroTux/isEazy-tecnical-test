<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShoppingController;
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

Route::get('/shops', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/shop', [ShopController::class, 'store'])->name('/shop.store');
Route::put('/shop', [ShopController::class, 'update'])->name('shop.edit');
Route::post('/shopping', ShoppingController::class)->name('shopping');

