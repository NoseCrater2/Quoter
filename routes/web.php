<?php

use Illuminate\Support\Facades\Route;

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
    return view('rollux');
});

Route::get('/stock', function () {
    return view('stock');
});



Route::get('/{any?}', function () {
    return view('rollux');
})->where('any','^(?!api\/)[\/\w\.-]*');

//Route::get('/home', 'HomeController@index')->name('home');

//Routes

