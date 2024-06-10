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


// Route::get('/', function(){
//     return view('/sample'); //untuk sample view
// }); 
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/search-filter', 'UtilsController@searchFilter')->name('search-filter');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    /******************************* */
    /********* ROUTE ADMIN ********* */
    /******************************* */
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['namespace' => 'Master', 'prefix' => 'master', 'as' => 'master.'], function () {
        Route::resource('user', 'MasterUserController');
        Route::resource('cabang', 'MasterCabangController');
        Route::resource('barang', 'MasterBarangController');
    });
    Route::resource('rekap-barang-masuk', 'RekapBarangMasukController');
    Route::resource('transaksi', 'TransaksiController');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
