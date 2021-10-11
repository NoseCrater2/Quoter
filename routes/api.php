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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user()->roles->{'name'};
// });

Route::post('login', 'Api\AuthController@login');
Route::post('logout', 'Api\AuthController@logout');
// registerClient
Route::post('register', 'Api\AuthController@register');
Route::post('register-client', 'Api\AuthController@registerClient');

Route::get('directory', 'GalleryController@showDirectory');





Route::resource('types', 'TypeController')->only('index','show');
Route::get('lines', 'LineController@index');

Route::resource('weaves', 'WeaveController')->only('index','show');
Route::resource('sunblinds', 'SunblindController')->only('index','show');

Route::resource('colors', 'ColorController')->only('index','show');

Route::get('variants/{slug}/{slugType}', 'VariantController@show');
Route::resource('variants', 'VariantController')->only('index','update');


Route::resource('products', 'Api\ProductController')->only('index','show');

Route::resource('motorization_types', 'MotorizationTypeController')->only('index','show');
Route::resource('motorizations', 'MotorizationController')->only('index','show');
Route::get('getFilteredMotorizations/{type}', 'MotorizationController@getFilteredMotorizations');

Route::resource('controls', 'ControlController')->only('index','show');
Route::resource('galleries', 'GalleryController')->only('index','show');

//Route::get('getVariants/{product}', 'Api\ProductController@getVariants');
Route::get('getTypes/{product}', 'Api\ProductController@getTypes');
Route::get('getLines/{slug}', 'TypeController@getLines');

Route::get('getVariants/{slug}', 'LineController@getVariants');
Route::get('getWeaves/{slug}', 'LineController@getWeaves');
Route::resource('subweaves', 'SubweaveController')->only('index');
Route::get('getTypeVariants/{slug}', 'TypeController@getTypeVariants');
Route::get('getVariantsByProduct/{product}', 'Api\ProductController@getVariantsByProduct');

Route::get('getSunblinds/{weave}', 'WeaveController@getSunblinds');

Route::get('getFilteredVariants/', 'VariantController@getFilteredVariants');




Route::post('importModels', 'VariantController@importModels');
Route::post('importExcel', 'VariantController@importExcel');

Route::post('importMotorizations', 'MotorizationController@importMotorizations');
Route::post('importGalleries', 'GalleryController@importGalleries');


Route::get('exportExcel', 'VariantController@exportExcel');

//

Route::post('importSunblinds', 'SunblindController@importSunblinds');




Route::get('getRelated/{variant}' , 'VariantController@getRelated');
Route::get('getRelatedBlinds/{sunblind}' , 'SunblindController@getRelatedBlinds');


Route::get('getColors/{slug}/{type}' , 'VariantController@getColors');
// Route::post('users' , 'UserController@store')->name('users.store');
Route::get('distributors' , 'UserController@distributors');
Route::post('netpay-intent-pay/{user}' , 'NetPayController@netpayIntentPay');
Route::middleware(['auth:sanctum'])->group(function()
{

    Route::post('checkPassword' , 'UserController@checkPassword')->name('password.check');
    Route::get('getMyInfo', 'UserController@getMyInfo');

    //Roles
    Route::resource('roles', 'RoleController');

    Route::resource('orders', 'OrderController')->only('index','show', 'store', 'update','destroy');
    Route::get('quotations','OrderController@quotations');
    Route::get('quotations-admin','OrderController@quotationsAdmin');
    Route::get('orders-admin','OrderController@ordersAdmin');
    Route::post('revalidate-item-quotation/{order}','BlindController@revalidateItemQuotation');
    Route::get('remove-order-marketcar/{order}', 'OrderController@removeOrderMarketcar');
    Route::get('remove-allorders-marketcar', 'OrderController@removeAllOrdersMarketcar');

    Route::post('buy/{order}','OrderController@buy');
    Route::get('spei-payment/{order}', 'OrderController@speiPayment');

    Route::post('netpay-save/{user}', 'NetPayController@saveClient');
    Route::post('netpay-add-card/{user}', 'NetPayController@addCard');
    Route::get('netpay-get-client/{user}', 'NetPayController@getClient');
    Route::post('netpay-delete-card/{user}', 'NetPayController@deleteCard');

    Route::get('change-state/{order}', 'OrderController@changeState');
    Route::post('executeactions-allorders/{action}', 'OrderController@executeActionsAllorders');

    Route::get('notifications', 'UserController@notifications');

    Route::get('changequoting/{order}','OrderController@changeToOrder');

    //Products
    // Route::post('products/store' , 'Api\ProductController@store')->name('products.store')->middleware('can:products.create');
    // Route::get('products' , 'Api\ProductController@index')->name('products.index')->middleware('can:products.index');
    // Route::get('products/create' , 'Api\ProductController@create')->name('products.create')->middleware('can:products.create');
    // Route::put('products/{product}' , 'Api\ProductController@update')->name('products.update')->middleware('can:products.edit');
    // Route::get('products/{product}' , 'Api\ProductController@show')->name('products.show')->middleware('can:products.show');
    // Route::delete('products/{product}' , 'Api\ProductController@destroy')->name('products.destroy')->middleware('can:products.destroy');
    // Route::get('products/{product}/edit' , 'Api\ProductController@edit')->name('products.edit')->middleware('can:products.edit');

    //users

    Route::resource('users', 'UserController')->only('index','show', 'store', 'update','destroy');
    Route::get('active-user/{user}','UserController@activeUser');
    //Route::get('products/create' , 'ProductController@create')->name('products.create')->middleware('permission:products.create');
    // Route::put('users/{user}','UserController@update')->name('users.update');
    // Route::get('users/{user}','UserController@show')->name('users.show');
    // Route::delete('users/{user}','UserController@destroy')->name('users.destroy');
    // Route::get('users/{user}/edit','UserController@edit')->name('users.edit');
    Route::delete('blinds/{blind}', 'BlindController@destroy');


});

Route::post('order-list-pdf' , 'Api\ProductController@exportPdf');
Route::post('auth-order-list-pdf-distributor' , 'Api\ProductController@exportPdfDistributor');
Route::post('auth-order-list-pdf-admins' , 'Api\ProductController@authExportPdf');
Route::post('send-order-email-pdf' , 'Api\ProductController@sendOrderEmail');
Route::post('sanctum/token','Auth\MobileAuthController@login');






Route::resource('prices', 'PriceController')->only('index','show', 'store', 'update','destroy');
Route::get('reset-password/{email}' , 'UserController@resetPassword');
