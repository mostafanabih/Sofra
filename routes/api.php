<?php

use App\Http\Controllers\Api\Resturant\RestaurantController;
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
Route::group(['prefix'=>'V1','namespace'=>'Api'],function(){
   Route::group(['namespace'=>'General'],function(){
       Route::get('cities','publicController@cities');

       Route::get('neighborhoods','publicController@neighborhood');

       Route::get('categories','publicController@categories');

       Route::get('restaurants','publicController@restaurants');

       Route::get('getRestaurants','publicController@getRestaurants');

       Route::get('products','publicController@products');

       Route::get('reviews','publicController@reviews');

       Route::post('contacts','publicController@contacts');

       Route::get('offers','publicController@offers');

       Route::get('aboutApp','publicController@aboutApp');

   });

    Route::group(['namespace'=>'Client'],function() {
        Route::post('clientRegister','AuthController@register');
        Route::post('clientLogin','AuthController@login');

        Route::post('clientResetPassword','AuthController@resetpassword');
        Route::post('clientNewPassword','AuthController@newpassword');

        Route::group(['middleware' => 'auth:client'], function () {
            Route::post('newOrder','ClientController@newOrder');

            Route::get('clientProfile','ClientController@profile');
            Route::post('clientEditProfile','ClientController@editProfile');

            Route::get('clientOrderDetail','ClientController@orderDetails');

            Route::post('deliverdOrder','ClientController@deliverdOrder');
            Route::post('declinedOrder','ClientController@declinedOrder');

            Route::post('addReview','ClientController@addReview');

            Route::post('registerToken','AuthController@registerToken');
            Route::post('removeToken','AuthController@removeToken');

            Route::get('currentOrder','ClientController@currentOrder');
            Route::get('pastOrder','ClientController@pastOrder');

        });
    });

    Route::group(['namespace'=>'Resturant'],function() {
        Route::post('restaurantRegister','AuthController@register');
        Route::post('restaurantLogin','AuthController@login');

        Route::post('restaurantResetPassword','AuthController@resetpassword');
        Route::post('restaurantNewPassword','AuthController@newpassword');

        Route::group(['middleware' => 'auth:restaurant'], function () {

            Route::get('restaurantOffers','RestaurantController@offers');
            Route::post('createOffer','RestaurantController@createOffer');
            Route::post('editOffer','RestaurantController@editOffer');
            Route::post('removeOffer','RestaurantController@removeOffer');

            Route::get('restaurantProducts','RestaurantController@products');
            Route::post('createProduct','RestaurantController@createProduct');
            Route::post('editProduct','RestaurantController@editProduct');
            Route::post('removeProduct','RestaurantController@removeProduct');

            Route::get('restaurantProfile','RestaurantController@profile');
            Route::post('restaurantEditProfile','RestaurantController@editProfile');

            Route::get('myReviews','RestaurantController@myReviews');

            Route::get('restaurantOrders','RestaurantController@restaurantOrders');
            Route::post('acceptOrder','RestaurantController@acceptOrder');
            Route::post('rejectOrder','RestaurantController@rejectOrder');

            Route::post('restaurantRegisterToken','AuthController@registerToken');
            Route::post('restaurantRemoveToken','AuthController@removeToken');

            Route::get('restaurantNewOrder','RestaurantController@newOrder');
            Route::get('restaurantCurrentOrder','RestaurantController@currentOrder');
            Route::get('restaurantPastOrder','RestaurantController@pastOrder');

            Route::get('commission','RestaurantController@commission');

        });
    });
});
