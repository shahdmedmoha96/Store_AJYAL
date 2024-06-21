<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboaedController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\ProductController;

Route::get('/dashboard',[ DashboaedController::class,'index'])
->middleware('auth','auth.type')
->name('dashboard');


Route::get('/categories/trash',[CategoriesController::class,'trash'])->name('categories.trash');
Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])->name('categories.restore');
Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'forceDelete'])->name('categories.forceDelete');// delete from database
Route::resource('dashboard/categories', CategoriesController::class)->middleware('auth');
Route::resource('dashboard/products', ProductController::class)->middleware('auth');
Route::get('/products/{product}/edit',[ProductController::class,'edit'])->name('products.edit');

