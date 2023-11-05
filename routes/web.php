<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('login');
})->name('login');

# Auth
Route::post('/', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.submit');

Route::middleware(['auth.users', 'share.notifications'])->group(function(){
    # Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    # Cart
    Route::post('/cart/product/add', [SellingController::class,'addToCart'])->name('add.cart');
    Route::post('/cart/product/remove', [SellingController::class,'removeItem'])->name('remove.item.from.cart');
    Route::get('/cart/product/{id}/quantity/edit', [SellingController::class,'editQuantity'])->name('edit.quantity');
    Route::put('/cart/product/{id}/quantity/edit', [SellingController::class,'updateQuantity'])->name('quantity.update');

    # Checkout
    Route::get('/checkout', [SellingController::class,'showCart'])->name('cart');
    Route::post('/promocode', [SellingController::class,'applyPromo'])->name('apply.promocode');

    Route::post('/sell', [SellingController::class,'sell'])->name('sell');

    # Notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark.read');
    Route::post('/notifications/{id}/mark/unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark.unread');
    Route::post('/notifications/{id}/destroy', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::get('/error/404', function(){
        return view('error', [
            'code' => 404,
        ]);
    })->name('not.found');

    Route::get('/error/403', function(){
        return view('error', [
            'code' => 403,
        ]);
    })->name('forbidden');
});

Route::get('/error/404', function(){
    return view('error', [
        'code' => 404,
    ]);
})->name('not.found');

Route::get('/error/403', function(){
    return view('error', [
        'code' => 403,
    ]);
})->name('forbidden');


# Admin Routes
Route::middleware(['auth.users', 'role:admin', 'share.notifications'])->prefix('admin')->group(function(){

    Route::resource('products', ProductController::class)->except([
        'index', 'show'
    ]);

    Route::post('products/store/excel', [ProductController::class,'storeExcel'])->name('products.store.excel');

    Route::resource('users', UserController::class)->except([
        'show'
    ]);

    Route::resource('promos', PromoCodeController::class)->except([
        'show'
    ]);

    Route::get('user/{id}/history', [UserController::class, 'history'])->name('user.history');
});
