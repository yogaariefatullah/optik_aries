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
    Route::resource('transaksi','TransaksiController');


    /******************************* */
    /***** ROUTE DOSEN + SISWA ***** */
    /******************************* */
    Route::get('/type', 'HomeController@SelectType')->name('type');
    Route::group(['namespace' => 'List', 'prefix' => 'list', 'as' => 'list.'], function () {
        //ebook
        Route::group(['prefix' => 'ebook', 'as' => 'ebook.'], function () {
            Route::get('/', 'ListEbookController@index')->name('index');
            Route::post('/detail', 'ListEbookController@detail')->name('detail');
            Route::get('/filter', 'ListEbookController@filter')->name('filter');
        });

        //audio
        Route::group(['prefix' => 'audio', 'as' => 'audio.'], function () {
            Route::get('/', 'ListAudioController@index')->name('index');
            Route::post('/detail', 'ListAudioController@detail')->name('detail');
            Route::get('/filter', 'ListAudioController@filter')->name('filter');
        });

        //video
        Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
            Route::get('/', 'ListVideoController@index')->name('index');
            Route::post('/detail', 'ListVideoController@detail')->name('detail');
            Route::get('/getFile', 'ListVideoController@getFile')->name('getfile');
            Route::get('/filter', 'ListVideoController@filter')->name('filter');
        });
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
