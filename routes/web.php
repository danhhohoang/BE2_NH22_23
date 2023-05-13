<?php


use App\Http\Controllers\AdminRatingController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\AdminProtype;
use App\Http\Controllers\AdminUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('index');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'isAdmin'])->name('dashboard');
//Get product by type_ID

Route::get('/shop-grid', [ProductController::class, 'drid']);
// Log out
Route::get('logout', function () {
    auth()->logout();
    Session()->flush();

    return redirect('/');
})->name('logout');
require __DIR__.'/auth.php';
//Get Detail product
Route::get('/shop-details/{id}', [ProductDetailsController::class, 'product_detail'])->name('shop.details');

// Search
Route::get('search', [ProductController::class, 'getSearch'])->name('search');
// Them san pham vao gio hang
Route::get('add-to-cart/{id}', [ProductController::class, 'getAddToCart'])->name('product.addToCart');
Route::get('shopping-cart', [ProductController::class, 'getCart'])->name('shoppingCart');

// Xoa san pham ra gio hang
Route::get('delete-to-cart/{id}', [ProductController::class, 'deleteItemCart']);
//Cap nhat tat ca san pham
Route::post('save-all', [ProductController::class, 'saveAllItemCart']);

//Checkout
Route::get('checkout', [ProductController::class, 'checkOut'])->name('checkOut');
Route::post('save-checkout', [ProductController::class, 'saveCheckOut'])->name('saveCheckOut');

//Transaction history
Route::get('transaction-history', [ProductController::class, 'transactionHistory'])->name('transactionHistory');
Route::get('transaction-detail/{id}', [ProductController::class, 'transactionDetail'])->name('transactionDetail');
//View all orders of Admin
Route::get('/dashboard/orders', [OrdersController::class, 'index'])->name('admin-view-orders');
//View new order
Route::get('/dashboard/new-orders', [DashboardController::class, 'newOder'])->name('admin-view-new-order');
//get list email newsletter 
Route::get('/dashboard/email-newsletter', [EmailController::class, 'getAllEmails'])->name('admin.email-letter');
//get from add user
Route::get('/dashboard/user/adduser', function () {
    return view('Admin.admin-addUser');
})->name('user.add');

//get from edit user
Route::get('/dashboard/user/edit/{id}', [AdminUser::class, 'edit'])->name('admin.edituser');

//update user
Route::put('/dashboard/protype/update', [AdminUser::class, 'update'])->name('admin.updateuser');

//get from list product
Route::get('/dashboard/product', [AdminProductController::class, 'product'])->name('admin.listproduct');

//get from add product
Route::get('/dashboard/product/add', [AdminProductController::class, 'add'])->name('admin.addproduct');

// add product
Route::post('/dashboard/product/add', [AdminProductController::class, 'addproduct'])->name('product.add');

//get from edit product
Route::get('/dashboard/product/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.editproduct');

//get update product
Route::put('/dashboard/product/edit', [AdminProductController::class, 'update'])->name('product.update');

//Delete user
Route::delete('/dashboard/product/{product}', [AdminProductController::class, 'destroy'])->name('delete.product');

//get list email newsletter 
Route::get('/dashboard/email-newsletter', [EmailController::class, 'getAllEmails'])->name('admin.email-letter');

//Delete email newsletter
Route::delete('/dashboard/email-newsletter/{email}', [EmailController::class, 'destroy'])->name('admin.delete-email-letter');

//get list protype
Route::get('/dashboard/protype', [AdminProtype::class, 'protype'])->name('admin.listprotype');

//add protype
Route::post('/dashboard/protype/add', [AdminProtype::class, 'add'])->name('admin.addprotype');

//get from add protype
Route::get('/dashboard/protype/addprotype', function () {
    return view('Admin.admin-addprotype');
})->name('protype.add');

//get from edit protype
Route::get('/dashboard/protype/edit/{id}', [AdminProtype::class, 'edit'])->name('admin.editprotype');

//update protype
Route::put('/dashboard/protype/update/{id}', [AdminProtype::class, 'update'])->name('admin.update');

//Delete protype
Route::delete('/dashboard/protype/{protype}', [AdminProtype::class, 'destroy'])->name('admin.protype');

//get from list user
Route::get('/dashboard/user', [AdminUser::class, 'user'])->name('admin.listuser');

//Delete user
Route::delete('/dashboard/user/{user}', [AdminUser::class, 'destroy'])->name('admin.user');

//add user
Route::post('/dashboard/user/add', [AdminUser::class, 'add'])->name('admin.adduser');
//View rating of admin
//View rating of admin
Route::get('/dashboard/rating', [AdminRatingController::class, 'index'])->name('admin-view-rating');

//Delete rating
Route::delete('/dashboard/rating/delete/{id}',[AdminRatingController::class,'destroy'])->name('admin-delete-rating');

    //View all orders of Admin
 Route::get('/dashboard/orders', [OrdersController::class, 'index'])->name('admin-view-orders');
 
    //View details orders of admin
 Route::get('/dashboard/orders/{id}', [OrdersController::class, 'find'])->name('admin-view-details-order');

