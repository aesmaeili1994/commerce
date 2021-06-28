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


    //route for edit images page of products
    Route::get('/products/{product}/images-edit',[\App\Http\Controllers\Admin\ProductImageController::class,'edit'])->name('products.images.edit');

    //routes for edit Images of products
    Route::delete('/products/{product}/images-destroy',[\App\Http\Controllers\Admin\ProductImageController::class,'destroy'])->name('products.images.destroy');
    Route::put('/products/{product}/images-set-primary',[\App\Http\Controllers\Admin\ProductImageController::class,'setPrimary'])->name('products.images.set_primary');
    Route::post('/products/{product}/images-add',[\App\Http\Controllers\Admin\ProductImageController::class,'add'])->name('products.images.add');

    //route for edit category&attributes of products
    Route::get('/products/{product}/category-edit',[\App\Http\Controllers\Admin\ProductController::class,'editCategory'])->name('products.category.edit');
    Route::put('/products/{product}/category-update',[\App\Http\Controllers\Admin\ProductController::class,'updateCategory'])->name('products.category.update');

});
