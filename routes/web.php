<?php

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

use Illuminate\Support\Facades\Route;
use function foo\func;


Route::get('/', function () {
    return view('layouts.signin');
    
});




Route::get('/newPassword','Admin\UserController@ResetPassword')->name('newPassword');
Route::post('/newPassword','Admin\UserController@NewPassword')->name('postNewPassword');
Route::get('/resetPassword','Admin\UserController@GetEmail')->name('resetPassword');
Route::post('/resetPassword','Admin\UserController@SendEmail')->name('postResetPassword');
Auth::routes();
Route::group(['middleware'=>'auth','prefix' => 'admin'],function (){
    Route::group(['middleware'=>['auth','auto-check-permission'],'namespace' => 'Admin'],function(){
        Route::get('/home', 'HomeController@index')->name('home');

        Route::resource('city','CityController');

        Route::resource('neighborhood','NeighborhoodController');

        Route::resource('category','CategoryController');

        Route::resource('payment','PaymentController');
        Route::get('search','PaymentController@search');

        Route::resource('offer','OfferController');
        Route::get('offersearch','OfferController@offersearch');

        Route::resource('contact','ContactController');
        Route::get('contactsearch','ContactController@contactsearch');

        Route::resource('review','ReviewController');
        Route::get('reviewsearch','ReviewController@reviewsearch');

        Route::resource('restaurant','RestaurantController');
        Route::post('status/{id}','RestaurantController@status');
        Route::get('restaurantsearch','RestaurantController@restaurantsearch');

        Route::resource('client','ClientController');
        Route::post('clientstatus/{id}','ClientController@clientstatus');
        Route::get('clientsearch','ClientController@clientsearch');

        Route::resource('order','OrderController');
        Route::get('ordersearch','OrderController@ordersearch');

        Route::resource('setting','SettingController');

        Route::resource('role','RoleController');

        Route::resource('user','UserController');
        Route::get('change','UserController@change');
        Route::post('changePassword','UserController@changePassword');
    });

});

Auth::routes();
Route::group(['prefix' => 'user','namespace'=>'Front'],function(){

    Route::get('index','MainController@index')->name('index');
    Route::get('searchrestaurant','MainController@searchrestaurant')->name('searchrestaurant');
    Route::get('allRestaurants','MainController@allRestaurants')->name('allRestaurants');

    Route::get('offers','MainController@offers')->name('offers');

    Route::get('contact','MainController@contact')->name('contact');
    Route::post('contactUs','MainController@contactUs');

    Route::get('restaurantDetail/{id}','MainController@restaurantDetail')->name('restaurantDetail');

    Route::get('mealDetail/{id}','MainController@mealDetail')->name('mealDetail');

    Route::get('add-to-cart/{id}', 'MainController@getAddToCart')->name('add-to-cart');
    Route::get('shoppingCart', 'MainController@shoppingCart')->name('shoppingCart');
    Route::get('reduce/{id}', 'MainController@getReduceByOne')->name('reduce');
    Route::get('remove/{id}', 'MainController@getRemoveItem')->name('remove');



    Route::group(['middleware'=>'check-auth'],function(){
        Route::get('clientlogin','AuthController@clientLogin')->name('clientlogin');
        Route::post('cllogin','AuthController@clLogin');

        Route::get('restaurantlogin','AuthController@restaurantLogin')->name('restaurantlogin');
        Route::post('reslogin','AuthController@resLogin');

        Route::get('getRegister','AuthController@getRegister')->name('getRegister');
        Route::post('clientRegister','AuthController@clientRegister')->name('clientRegister');

        Route::get('resGetRegister','AuthController@resGetRegister')->name('resGetRegister');
        Route::post('restaurantRegister','AuthController@restaurantRegister')->name('restaurantRegister');

        Route::get('/clNewPassword','AuthController@clResetPassword')->name('clNewPassword');
        Route::post('/clNewPassword','AuthController@clNewPassword')->name('postclNewPassword');
        Route::get('/clResetPassword','AuthController@clGetEmail')->name('clResetPassword');
        Route::post('/clResetPassword','AuthController@clSendEmail')->name('postclResetPassword');

        Route::get('/resNewPassword','AuthController@resResetPassword')->name('resNewPassword');
        Route::post('/resNewPassword','AuthController@resNewPassword')->name('postresNewPassword');
        Route::get('/resResetPassword','AuthController@resGetEmail')->name('resResetPassword');
        Route::post('/resResetPassword','AuthController@resSendEmail')->name('postresResetPassword');

    });

    Route::group(['middleware'=>'auth:web-restaurant'],function(){
        Route::get('user/logouts',function(){
            auth()->guard('web-restaurant')->logout();
            return redirect('user/index');
        })->name('restlogout');

        Route::get('resProfile','MainController@resProfile')->name('resProfile');
        Route::post('restaurantProfile','MainController@restaurantProfile');

        Route::get('restaurantOffer','MainController@restaurantOffer')->name('restaurantOffer');

        Route::get('resSeller','MainController@resSeller')->name('resSeller');

        Route::get('getOffer','MainController@getOffer')->name('getOffer');
        Route::post('addOffer','MainController@addOffer');

        Route::get('getProduct','MainController@getProduct')->name('getProduct');
        Route::post('addProduct','MainController@addProduct');

        Route::get('myOrders','MainController@myOrders')->name('myOrders');
        Route::get('currentOrder','MainController@currentOrder')->name('currentOrder');
        Route::get('pastOrder','MainController@pastOrder')->name('pastOrder');

        Route::get('acceptOrder/{id}','MainController@acceptOrder')->name('acceptOrder');
        Route::get('rejectOrder/{id}','MainController@rejectOrder')->name('rejectOrder');
        Route::get('deliverOrder/{id}','MainController@deliverOrder')->name('deliverOrder');

        Route::get('getEditProduct/{id}','MainController@getEditProduct')->name('getEditProduct');
        Route::put('editProduct/{id}','MainController@editProduct');
        Route::get('deleteProduct/{id}/delete','MainController@deleteProduct')->name('deleteProduct');

        Route::get('getEditOffer/{id}','MainController@getEditOffer')->name('getEditOffer');
        Route::put('editOffer/{id}','MainController@editOffer');
        Route::get('deleteOffer/{id}/delete','MainController@deleteOffer')->name('deleteOffer');

        Route::get('restaurantNotification','MainController@restaurantNotification')->name('restaurantNotification');


    });

    Route::group(['middleware'=>'auth:web-client'],function(){
        Route::get('user/logout',function(){
            auth()->guard('web-client')->logout();
            return redirect('user/index');
        })->name('clientlogout');

        Route::get('getProfile','MainController@getProfile')->name('getProfile');
        Route::post('clientProfile','MainController@clientProfile');

        Route::get('clientCurrentOrder','MainController@clientCurrentOrder')->name('clientCurrentOrder');
        Route::get('clientPastOrder','MainController@clientPastOrder')->name('clientPastOrder');

        Route::get('deliverdOrder/{id}','MainController@deliverdOrder')->name('deliverdOrder');
        Route::get('decliendOrder/{id}','MainController@decliendOrder')->name('decliendOrder');

        Route::get('checkout', function(){
            return view('site.add-order');
        });
        Route::post('add-order', 'MainController@addOrder')->name('add-order');
    });

});

