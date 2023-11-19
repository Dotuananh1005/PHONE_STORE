<?php

use Illuminate\Support\Facades\Route;

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

Route::post( '/register', [App\Http\Controllers\Auth\LoginController::class, 'register'])->name('register');
Route::get('/show/register', [App\Http\Controllers\Auth\LoginController::class, 'showRegister'])->name('show_register');
Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
//Product
Route::get('/adminProduct', [App\Http\Controllers\ProductController::class, 'index'])->name('route_product');
Route::match(['GET', 'POST'], '/product/add', [App\Http\Controllers\ProductController::class, 'addProduct'])->name('route_product_add');
Route::match(['GET', 'POST'], '/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'editProduct'])->name('route_product_edit');
Route::get('/product/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('route_product_delete');
//Category
Route::get('/adminCategory', [App\Http\Controllers\CategoryController::class, 'index'])->name('route_category');
Route::match(['GET', 'POST'], '/category/add', [App\Http\Controllers\CategoryController::class, 'addCategory'])->name('route_category_add');
Route::match(['GET', 'POST'], '/category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'editCategory'])->name('route_category_edit');
Route::get('/category/delete/{id}', [App\Http\Controllers\CategoryController::class, 'delete'])->name('route_category_delete');
//Coupon
Route::get('/adminCoupon', [App\Http\Controllers\CouponController::class, 'index'])->name('route_coupon');
Route::match(['GET', 'POST'], '/coupon/add', [App\Http\Controllers\CouponController::class, 'addCoupon'])->name('route_coupon_add');
Route::match(['GET', 'POST'], '/coupon/edit/{id}', [App\Http\Controllers\CouponController::class, 'editCoupon'])->name('route_coupon_edit');
Route::get('/cSoupon/delete/{id}', [App\Http\Controllers\CouponController::class, 'delete'])->name('route_coupon_delete');
//cart
Route::middleware(['auth'])->group(function () {
    Route::post('/add-to-cart/{product}', [App\Http\Controllers\CartController::class, 'addToCart'])->middleware('auth')->name('cart.add');
    Route::post('/add-to-cart/{model}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add2');
    Route::get('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'showCart'])->name('route_cart');
    Route::post('/update-cart', [App\Http\Controllers\CartController::class, 'updateCart'])->name('update.cart');
// bill
    Route::get('/bill', [App\Http\Controllers\BillController::class, 'showBill'])->name('route_bill');
    Route::get('bills', [App\Http\Controllers\BillController::class, 'index'])->name('admin.bills.index');
    Route::get('bills/{id}', [App\Http\Controllers\BillController::class, 'show'])->name('admin.bills.show');
    Route::post('/checkout', [App\Http\Controllers\BillController::class, 'checkout'])->name('checkout');
    Route::post('/apply-coupon', [App\Http\Controllers\BillController::class, 'applyCoupon'])->name('apply-coupon');
    Route::patch('/admin/orders/{id}/update-status', [App\Http\Controllers\BillController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/auth/bills', [App\Http\Controllers\BillController::class, 'showInvoice'])->name('route_invoices');
});



//ViewHome
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/{slug}', [App\Http\Controllers\HomeController::class, 'view'])->name('view');
