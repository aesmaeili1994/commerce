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

Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::prefix('admin-panel/management')->name('admin.')->group(function () {
    Route::resource('brands',\App\Http\Controllers\Admin\BrandController::class);
    Route::resource('attributes',\App\Http\Controllers\Admin\AttributeController::class);
    Route::resource('categories',\App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('tags',\App\Http\Controllers\Admin\TagController::class);
    Route::resource('products',\App\Http\Controllers\Admin\ProductController::class);

    //get category attribute by ajax for create page product section attribute@variation
    Route::get('/category-attributes/{category}',[\App\Http\Controllers\Admin\CategoryController::class,'getCategoryAttributes']);
});
