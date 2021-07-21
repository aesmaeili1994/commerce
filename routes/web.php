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
    Route::resource('banners',\App\Http\Controllers\Admin\BannerController::class);
    Route::resource('comments',\App\Http\Controllers\Admin\CommentController::class);
    Route::resource('coupons',\App\Http\Controllers\Admin\CouponController::class);
    Route::resource('orders',\App\Http\Controllers\Admin\OrderController::class);
    Route::resource('transactions',\App\Http\Controllers\Admin\TransactionController::class);

    //route for change approve comment
    Route::get('/comments/{comment}/change-approve',[\App\Http\Controllers\Admin\CommentController::class,'changeApprove'])->name('comments.change-approve');


    //get category attribute by ajax for create page product section attribute&variation
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

Route::get('/',[\App\Http\Controllers\Home\HomeController::class,'index'])->name('home.index');
Route::get('/categories/{category:slug}',[\App\Http\Controllers\Home\CategoryController::class,'show'])->name('home.categories.show');
Route::get('/products/{product:slug}',[\App\Http\Controllers\Home\ProductController::class,'show'])->name('home.products.show');
Route::post('/comments/{product}',[\App\Http\Controllers\Home\CommentController::class,'store'])->name('home.comments.store');

//route for Wishlist
Route::get('/add-to-wishlist/{product}',[\App\Http\Controllers\Home\WishlistController::class,'add'])->name('home.wishlist.add');
Route::get('/remove-from-wishlist/{product}',[\App\Http\Controllers\Home\WishlistController::class,'remove'])->name('home.wishlist.remove');

//route for compare
Route::get('/compare',[\App\Http\Controllers\Home\CompareController::class,'index'])->name('home.compare.index');
Route::get('/add-to-compare/{product}',[\App\Http\Controllers\Home\CompareController::class,'add'])->name('home.compare.add');
Route::get('/remove-from-compare/{product}',[\App\Http\Controllers\Home\CompareController::class,'remove'])->name('home.compare.remove');

//route for cart
Route::get('/cart',[\App\Http\Controllers\Home\CartController::class,'index'])->name('home.cart.index');
Route::post('/add-to-cart',[\App\Http\Controllers\Home\CartController::class,'add'])->name('home.cart.add');
Route::get('/remove-from-cart/{rowId}',[\App\Http\Controllers\Home\CartController::class,'remove'])->name('home.cart.remove');
Route::put('/cart',[\App\Http\Controllers\Home\CartController::class,'update'])->name('home.cart.update');
Route::get('/clear-cart',[\App\Http\Controllers\Home\CartController::class,'clear'])->name('home.cart.clear');
Route::post('/check-coupon',[\App\Http\Controllers\Home\CartController::class,'checkCoupon'])->name('home.coupons.check');
Route::get('/checkout',[\App\Http\Controllers\Home\CartController::class,'checkout'])->name('home.orders.checkout');

//route for payment
Route::post('/payment',[\App\Http\Controllers\Home\PaymentController::class,'payment'])->name('home.payment');
Route::get('/payment-verify/{gatewayName}',[\App\Http\Controllers\Home\PaymentController::class,'paymentVerify'])->name('home.payment_verify');

//Oauth
Route::get('/login/{provider}',[\App\Http\Controllers\Auth\AuthController::class,'redirectToProvider'])->name('provider.login');
Route::get('/login/{provider}/callback',[\App\Http\Controllers\Auth\AuthController::class,'handleProviderCallback']);

Route::prefix('profile')->name('home.')->group(function () {
    Route::get('/',[\App\Http\Controllers\Home\UserProfileController::class,'index'])->name('users_profile.index');

    Route::get('/comments',[\App\Http\Controllers\Home\CommentController::class,'usersProfileIndex'])->name('comments.users_profile.index');

    Route::get('/wishlist',[\App\Http\Controllers\Home\WishlistController::class,'usersProfileIndex'])->name('wishlist.users_profile.index');

    Route::get('/addresses',[\App\Http\Controllers\Home\AddressController::class,'index'])->name('addresses.index');
    Route::post('/addresses',[\App\Http\Controllers\Home\AddressController::class,'store'])->name('addresses.store');
    Route::put('/addresses/{address}',[\App\Http\Controllers\Home\AddressController::class,'update'])->name('addresses.update');

    Route::get('/orders',[\App\Http\Controllers\Home\OrderController::class,'index'])->name('orders.index');
});

Route::get('/get-province-cities-list',[\App\Http\Controllers\Home\AddressController::class,'getProvinceCitiesList']);

Route::get('/test',function (){
//    auth()->logout();
//    dd(session()->get('compareProducts'));
//    \Cart::clear();
//    dd(\Cart::getContent());
    dd(session()->get('coupon'));
});
