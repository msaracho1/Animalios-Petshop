<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [HomeController::class, 'about'])->name('about');

Route::get('/tienda', [StoreController::class, 'index'])->name('store.index');
Route::get('/producto/{id}', [StoreController::class, 'show'])->name('store.show');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
| Login/registro/logout normalmente ya están en routes/auth.php
*/

/*
|--------------------------------------------------------------------------
| Cart + Checkout (cliente logueado)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
    Route::post('/carrito/quitar', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/carrito/actualizar', [CartController::class, 'update'])->name('cart.update');

    Route::get('/pedidos', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{id}', [OrdersController::class, 'show'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/usuarios', [AdminUserController::class, 'index'])->name('admin.users.index');

    Route::get('/productos', [AdminProductController::class, 'index'])->name('admin.products.index');

    Route::get('/pedidos', [AdminOrderController::class, 'index'])->name('admin.orders.index');
});

use App\Http\Controllers\CheckoutController;

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('auth')
    ->name('checkout');


Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::resource('productos', AdminProductController::class)
        ->names('admin.products')
        ->except(['show']);
});