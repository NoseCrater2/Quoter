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
    return $request->user()->roles->{'name'};
});

Route::post('login', 'Api\AuthController@login');
Route::post('logout', 'Api\AuthController@logout');
Route::post('register', 'Api\AuthController@register');

Route::post('register', 'Api\AuthController@register');

Route::resource('types', 'TypeController')->only('index','show');
Route::resource('lines', 'LineController')->only('index','show');
Route::resource('colors', 'ColorController')->only('index','show');
Route::resource('manufacturers', 'ManufacturerController')->only('index','show');
Route::resource('variants', 'VariantController')->only('index','show');

Route::post('importExcel', 'VariantController@importExcel');

Route::middleware(['auth:api'])->group(function()
{

    Route::post('checkPassword' , 'UserController@checkPassword')->name('password.check');

    Route::get('getMyInfo', 'UserController@getMyInfo');

    //Roles
    Route::resource('roles', 'RoleController');
   
    //Products
    Route::post('products/store' , 'Api\ProductController@store')->name('products.store')->middleware('can:products.create');
    Route::get('products' , 'Api\ProductController@index')->name('products.index')->middleware('can:products.index');
    Route::get('products/create' , 'Api\ProductController@create')->name('products.create')->middleware('can:products.create');
    Route::put('products/{product}' , 'Api\ProductController@update')->name('products.update')->middleware('can:products.edit');
    Route::get('products/{product}' , 'Api\ProductController@show')->name('products.show')->middleware('can:products.show');
    Route::delete('products/{product}' , 'Api\ProductController@destroy')->name('products.destroy')->middleware('can:products.destroy');
    Route::get('products/{product}/edit' , 'Api\ProductController@edit')->name('products.edit')->middleware('can:products.edit');

    //users
   Route::post('users' , 'UserController@store')->name('users.store');
    Route::get('users','UserController@index')->name('users.index');
    //Route::get('products/create' , 'ProductController@create')->name('products.create')->middleware('permission:products.create');
    Route::put('users/{user}','UserController@update')->name('users.update');
    Route::get('users/{user}','UserController@show')->name('users.show');
    Route::delete('users/{user}','UserController@destroy')->name('users.destroy');
    Route::get('users/{user}/edit','UserController@edit')->name('users.edit');
  
});