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


Route::post('/log', 'UserController@log');
Route::get('/logout', 'UserController@logout');

Route::get('/productadd', 'ProductController@productadd');
Route::get('/deleteProduct', 'ProductController@deleteProduct');
Route::get('/productedit', 'ProductController@productedit');
