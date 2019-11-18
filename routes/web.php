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

use App\Events\OrderLineStatusUpdated;
use App\Order;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

//Route::get('/orders/showAsync/{id}', 'OrderController@showAsync');

// Resources
Route::resource('orders', 'OrderController');
Route::resource('orderLines', 'OrderLineController');
Route::resource('products', 'ProductController');
Route::resource('photos', 'PhotoController');
Route::resource('photoLines', 'PhotoLineController');
Route::resource('customers', 'CustomerController');
Route::resource('photographers', 'PhotographerController');

Route::get('/info', function (){
    phpinfo();
});
