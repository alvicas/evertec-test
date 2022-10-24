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
    return redirect('productos');
});

Route::get('/productos', 'HomeController@home')->name('home.info');

//Product
Route::get('/products', 'Product\ProductIndexController@index')->name('product.index');
Route::get('/product/{id}', 'Product\ProductShowController@show')->name('product.show');
Route::get('/comprar-producto/{product}', 'Product\BuyProductController@buyProduct')->name('product.buy');

//Order
Route::post('/order/create', 'Order\OrderCreateController@create')->name('order.create');
Route::get('/orden/detalle/{order}', 'Order\OrderShowController@show')->name('order.show');
Route::get('/order/payment-attemp/{order}', 'Order\PayOrderController@paymentAttemp')->name('order.payment-attemp');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
