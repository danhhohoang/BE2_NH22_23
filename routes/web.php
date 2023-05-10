<?php

use App\Http\Controllers\AdminRatingController;
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

Route::get('/', function () {
    return view('welcome');
});
 //View rating of admin
 Route::get('/dashboard/rating', [AdminRatingController::class, 'index'])->name('admin-view-rating');

 //Delete rating
 Route::delete('/dashboard/rating/delete/{id}',[AdminRatingController::class,'destroy'])->name('admin-delete-rating');
