<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

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
