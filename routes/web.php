<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

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

// Auth Routes
Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes();
    Route::get('login/facebook',  'Auth\LoginController@redirectToFacebookProvider');
    Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookProviderCallback');
});

// Site Routes
Route::prefix('/')->group(function () {
    Route::get('/', 'SiteController@landing')->name('landing');
    Route::get('about', 'SiteController@about')->name('about');
    Route::get('admin', [
        'uses' => 'SiteController@admin',
        'as' => 'admin',
        'middleware' => ['auth', 'roles'],
        'roles' => ['admin']
    ]);
});



//Library routes
Route::as('library')->prefix('library')->group(function () {
    Route::get('/', 'LibraryController@index');
    Route::get('/search', 'LibraryController@search')->name('.search');
    Route::get('/books/{slug}', 'LibraryController@show')->name('.show');
});

// Our Authors Routes
Route::as('authors')->prefix('authors')->group(function () {
    Route::get('/', 'AuthorController@index');
    Route::get('/{id}', 'AuthorController@show')->name('.show');
});

// Cart Routes
Route::as('cart')->prefix('cart')->group(function () {
    Route::get('/', 'CartController@index');
    Route::post('/', 'CartController@store')->name('.store');
    Route::get('/count', 'CartController@count')->name('.count');
    Route::delete('/{book_id}', 'CartController@destroy')->name('.destroy');
    Route::patch('/{book_id}', 'CartController@update')->name('.update');
    Route::post('/moveToWishlist/{book_id}', 'CartController@moveToWishlist')->name('.moveToWishlist');
    Route::get('/empty', 'CartController@empty')->name('.empty');
});

//Wishlist Routes
Route::as('wishlist')->prefix('wishlist')->group(function () {
    Route::post('/', 'WishlistController@store')->name('.store');
    Route::delete('/{book_id}', 'WishlistController@destroy')->name('.destroy');
    Route::post('/moveToCart/{book_id}', 'WishlistController@moveToCart')->name('.moveToCart');
    Route::get('/empty', 'WishlistController@empty')->name('.empty');
});

// Review Routes
Route::as('review')->prefix('review')->group(function () {

    Route::post('/', 'ReviewController@store')->name('.store')->middleware('auth');
    Route::delete('/{review_id}', 'ReviewController@destroy')->name('.destroy')->middleware('auth');
    Route::put('/{review_id}', 'ReviewController@update')->name('.update')->middleware('auth');
    Route::get('/book/{book_id}', 'ReviewController@forbook')->name('forbook');
});

//Coupon Routes
Route::as('coupon')->prefix('coupon')->group(function () {
    Route::post('/', 'CouponController@store')->name('.store');
    Route::delete('/', 'CouponController@destroy')->name('.destroy');
});

//Checkout Routes
Route::as('checkout')->prefix('checkout')->middleware('auth')->group(function () {
    Route::get('/', 'CheckoutController@index');
    Route::post('/', 'CheckoutController@store')->name('.store');
    Route::get('/thankyou', 'CheckoutController@thankyou')->name('.thankyou');
});

// User Routes
Route::group(['middleware' => ['auth', 'prevent-back-history'], 'as' => "user", 'prefix' => 'user'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('.dashboard');
    Route::get('/profile', 'DashboardController@profile')->name('.profile');
    Route::put('/profile/update', 'DashboardController@updateProfile')->name('.profile.update');
    Route::get('/password/edit', 'DashboardController@editPassword')->name('.password.edit');
    Route::put('/password/update', 'DashboardController@updatePassword')->name('.password.update');
    Route::get('/orders', 'DashboardController@userOrders')->name('.orders');
    Route::get('/orders/{order_id}', 'DashboardController@userOrdersDetails')->name('.orders.details');
});
Route::fallback(function () {
    return view('errors.404');
});
// A little adjust to fit vue js routes
// Route::get('/admin/{path}', "SiteController@admin")->where('path', '([A-z\d\-\/_.]+)?');
Route::get('/admin/{path}', [
    'uses' => 'SiteController@admin',
    'middleware' => ['auth', 'roles'],
    'roles' => ['admin']
])->where('path', '([A-z\d\-\/_.]+)?');
