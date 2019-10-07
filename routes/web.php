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

Route::get('/', 'OrderController@create');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

// Resources
Route::resource('orders', 'OrderController');
Route::resource('products', 'ProductController');
Route::resource('photos', 'PhotoController');
Route::resource('photoLines', 'PhotoLineController');
Route::resource('customers', 'CustomerController');
