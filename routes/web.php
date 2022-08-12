<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\UserController;
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
    return view('auth.login');
});


Route::resource('restaurants',RestaurantController::class);
Route::resource('document-types',DocumentTypeController::class);
Route::resource('users',UserController::class);


Route::post('drop-zone',[DocumentController::class,'dropZone'])->name('dropZone');
Route::get('get-restaurant',[DocumentController::class,'getRestaurant'])->name('getRestaurant');
Route::get('delete-attachements',[DocumentController::class,'deleteAttachements'])->name('deleteAttachements');
Route::get('restaurant-name',[DocumentController::class,'restaurantName'])->name('restaurantName');
Route::get('delete-restaurant/{id}',[DocumentController::class,'deleteRestaurant'])->name('deleteRestaurant');
Route::get('document/{id}',[DocumentController::class,'documentType'])->name('documentType');

Route::resource('documents',DocumentController::class);
Route::get('advance-filter', [FilterController::class,'filter'])->name('advance.filter');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
