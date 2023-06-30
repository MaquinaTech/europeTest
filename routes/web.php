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

Auth::routes();

//Route::get('/home', 'HomeController@index');
Route::get('/home', 'PerroController@index');
Route::get('/perros', 'PerroController@index');
Route::get('/perros/{id}', 'PerroController@edit')->name('perros.edit');
Route::put('/perros/{id}', 'PerroController@update')->name('perros.update');
Route::delete('/perros/{id}', 'PerroController@destroy')->name('perros.destroy');


