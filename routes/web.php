<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DistributorApplicationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DistributorApplicationAdminController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductAdminController;

// Landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Post-login dashboard route
Route::middleware('auth')->get('/dashboard', function (Request $request) {
    if ($request->user()?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('shop.products');
})->name('dashboard');

// Customer Routes
Route::get('/shop', [ProductController::class, 'index'])->name('shop.products');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{category}', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/become-distributor', [DistributorApplicationController::class, 'create'])->name('distributor.apply');
Route::post('/become-distributor', [DistributorApplicationController::class, 'store'])->name('distributor.store');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Order Routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('order.process');
Route::get('/order/{orderId}/success', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/{orderId}/receipt', [OrderController::class, 'receipt'])->name('order.receipt');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Orders Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/order/{orderId}', [AdminController::class, 'orderDetail'])->name('order.detail');
    Route::put('/order/{orderId}/status', [AdminController::class, 'updateOrderStatus'])->name('order.status');
    
    // Inventory Management
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/{productId}/production', [InventoryController::class, 'addProduction'])->name('inventory.production');
    Route::post('/inventory/{productId}/production', [InventoryController::class, 'storeProduction'])->name('inventory.store-production');
    Route::get('/inventory/{productId}/adjustment', [InventoryController::class, 'adjustment'])->name('inventory.adjustment');
    Route::post('/inventory/{productId}/adjustment', [InventoryController::class, 'storeAdjustment'])->name('inventory.store-adjustment');
    Route::get('/inventory/report', [InventoryController::class, 'report'])->name('inventory.report');
    
    // Products Management
    Route::resource('products', ProductAdminController::class);

    // Distributor Applications
    Route::get('/distributors', [DistributorApplicationAdminController::class, 'index'])->name('distributors.index');
    Route::patch('/distributors/{application}/status', [DistributorApplicationAdminController::class, 'updateStatus'])->name('distributors.status');
});
