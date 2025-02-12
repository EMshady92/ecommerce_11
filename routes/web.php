<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInShoppingCartsController;
use App\Http\Controllers\ShoppingCartController;
use Inertia\Inertia;
use App\Http\Controllers\OrderController;
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

Route::get('/', [MainController::class, 'home'])->name('home');
Route::resource('products',ProductController::class);
Route::get('products_get',[ProductController::class, 'products_get']);
Route::post('save_product',[ProductController::class, 'save_product']);
Route::post('update_product/{id}', [ProductController::class, 'update_product']);
Route::resource('in_shopping_carts', ProductInShoppingCartsController::class);
Route::get('carrito', [ShoppingCartController::class,'show'])->name('shopping_cart.show');
Route::get('/carrito/productos', [ShoppingCartController::class,'products'])->name('shopping_cart.products');

Route::post('/payments/pay', [App\Http\Controllers\PaymentController::class, 'pay'])->name('pay');
Route::get('/payments/approval', [App\Http\Controllers\PaymentController::class, 'approval'])->name('approval');
Route::get('/payments/cancelled', [App\Http\Controllers\PaymentController::class, 'cancelled'])->name('cancelled');




Route::get('ticket', [OrderController::class, 'show'])->name('ticket');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


