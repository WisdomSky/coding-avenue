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

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


Route::group(['prefix' => 'r'], function () {
    Route::put('posts', 'PostController@massUpdate');
    Route::delete('posts', 'PostController@massDestroy');
    Route::resource('posts', 'PostController');
});


Route::get('login', 'MainController@index')->name('login');


Route::get('/', 'MainController@index');
Route::get('{any}', 'MainController@index')->where('any', '.+');