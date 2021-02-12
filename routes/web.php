<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
Route::get('/clear-all-cache', function() {
    Artisan::call('config:clear');
    echo "Cleared all caches successfully.";
  });
Auth::routes();

Route::middleware('auth')->get('/user',function (Request $request){
    return $request->user();
});

Route::get('/models/search', 'VariantController@getSearch');



Route::get('/{any?}', function () {
    return view('welcome');
})->where('any','^(?!api\/)[\/\w\.-]*');

//Route::get('/home', 'HomeController@index')->name('home');

//Routes

