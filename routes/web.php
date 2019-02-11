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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/addproduct', function () {
    return view('addProduct');
});

Route::get('/editProduct', function () {
    return view('editProduct');
});
Route::get('/productinfo', function () {
    return view('productinfo');
});

Route::post('/log', 'UserController@log');
Route::get('/logout', 'UserController@logout');

Route::post('/productadd', 'ProductController@productadd');
Route::get('/deleteProduct', 'ProductController@deleteProduct');
Route::get('/productedit', 'ProductController@productedit');
Route::get('/productrate', 'ProductController@productrate');
Route::get('/writereview', 'ProductController@writereview');
Route::get('/deletefew', 'ProductController@deletefew');
Route::get('/taxchange', 'ProductController@taxchange');
Route::get('/taxrate', 'ProductController@taxrate');
Route::get('/discset', 'ProductController@discset');

Route::post('/revsdisplay', 'ProductController@revsdisplay');
Route::post('/prodinfo', 'ProductController@prodinfo');

