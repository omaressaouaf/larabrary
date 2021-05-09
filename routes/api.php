<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api', 'rolesApi']], function () {

    Route::get('/users/authors', 'API\UserController@authors');
    Route::get('/roles/search', 'API\RoleController@search');

    Route::apiResources([
        'users' => 'API\UserController'
    ]);
    Route::apiResources([
        'roles' => 'API\RoleController'
    ]);
    Route::delete('/books/bulk/{ids}','API\BookController@bulk_destroy');
    Route::apiResources([
        'books' => 'API\BookController'
    ]);
    Route::apiResources([
        'genres' => 'API\GenreController'
    ]);
    Route::get('/orders', 'API\OrderController@index');
    Route::get('/orders/{id}', 'API\OrderController@details');
    Route::delete('/orders/{id}', 'API\OrderController@destroy');
    Route::put('/orders/{id}', 'API\OrderController@update');



    Route::get('/dashboard/count', 'API\DashboardController@count');
    Route::get('/dashboard/charts', 'API\DashboardController@charts');

    Route::get('/notifications/getUnreadNotificationsCount', 'API\NotificationController@getUnreadNotificationsCount');
    Route::get('/notifications/getUnreadNotifications', 'API\NotificationController@getUnreadNotifications');
});
// Route::get('/auth/currentUser', 'API\AuthController@getCurrentUser')->middleware('auth:api');
