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
Route::get('/', 'UtilsController@index')->name('/');
Route::get('/search-filter', 'UtilsController@searchFilter')->name('search-filter');

Auth::routes();

Route::group(['middleware' => 'auth'], function (){

    /******************************* */
    /********* ROUTE ADMIN ********* */
    /******************************* */
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['namespace' => 'Master', 'prefix' => 'master','as' => 'master.'],function (){
        Route::resource('subject', 'MasterSubjectController');
        Route::resource('menu', 'MasterMenuController');
        Route::resource('group', 'MasterGroupController');
        Route::post('group/update/{id}', 'MasterGroupController@update')->name('group.updatepermission');
    });
    
    Route::group(['namespace' => 'Arsip', 'prefix' => 'arsip','as' => 'arsip.'],function (){
        
        // foto
        Route::resource('foto', 'ArsipFotoController');
        Route::post('foto/upload', 'ArsipFotoController@upload')->name('foto.upload');
        Route::post('foto/upload/edit/{id}', 'ArsipFotoController@uploadEdit')->name('foto.upload.edit');
        Route::post('foto/hapus/{id}', 'ArsipFotoController@destroyFile')->name('foto.destroy.file');
        Route::get('foto/refresh/edit/{id}', 'ArsipFotoController@refresh')->name('foto.edit.refresh');
    
        // video
        Route::resource('video', 'ArsipVideoController');
        Route::post('video/upload', 'ArsipVideoController@upload')->name('video.upload');
        Route::post('video/upload/edit/{id}', 'ArsipVideoController@uploadEdit')->name('video.upload.edit');
        Route::post('video/hapus/{id}', 'ArsipVideoController@destroyFile')->name('video.destroy.file');
        Route::get('video/refresh/edit/{id}', 'ArsipVideoController@refresh')->name('video.edit.refresh');
    });
    
    Route::group(['namespace' => 'Pustaka', 'prefix' => 'pustaka','as' => 'pustaka.'],function (){
    
        //buku
        Route::resource('buku', 'PustakaBukuController');
        Route::post('buku/upload', 'PustakaBukuController@upload')->name('buku.upload');
        Route::post('buku/detail', 'PustakaBukuController@detail')->name('buku.detail');
        Route::post('buku/upload/edit/{id}', 'PustakaBukuController@uploadEdit')->name('buku.upload.edit');
        
        // video
        Route::resource('video', 'PustakaVideoController');
        Route::post('video/upload', 'PustakaVideoController@upload')->name('video.upload');
        Route::post('video/upload/edit/{id}', 'PustakaVideoController@uploadEdit')->name('video.upload.edit');
        Route::post('video/hapus/{id}', 'PustakaVideoController@destroyFile')->name('video.destroy.file');
        Route::get('video/refresh/edit/{id}', 'PustakaVideoController@refresh')->name('video.edit.refresh');
        Route::post('video/detail', 'PustakaVideoController@detail')->name('video.detail');
    
        //audio
        Route::resource('audio', 'PustakaAudioController');
        Route::post('audio/upload', 'PustakaAudioController@upload')->name('audio.upload');
        Route::post('audio/upload/edit/{id}', 'PustakaAudioController@uploadEdit')->name('audio.upload.edit');
        Route::post('audio/detail', 'PustakaAudioController@detail')->name('audio.detail');
    });


    /******************************* */
    /***** ROUTE DOSEN + SISWA ***** */
    /******************************* */
    Route::get('/type', 'HomeController@SelectType')->name('type');
    Route::group(['namespace' => 'List', 'prefix' => 'list','as' => 'list.'],function (){
        //ebook
        Route::group(['prefix' => 'ebook','as' => 'ebook.'],function (){
            Route::get('/','ListEbookController@index')->name('index');
            Route::post('/detail','ListEbookController@detail')->name('detail');
            Route::get('/filter','ListEbookController@filter')->name('filter');
        });

        //audio
        Route::group(['prefix' => 'audio','as' => 'audio.'],function (){
            Route::get('/','ListAudioController@index')->name('index');
            Route::post('/detail','ListAudioController@detail')->name('detail');
            Route::get('/filter','ListAudioController@filter')->name('filter');
        });

        //video
        Route::group(['prefix' => 'video','as' => 'video.'],function (){
            Route::get('/','ListVideoController@index')->name('index');
            Route::post('/detail','ListVideoController@detail')->name('detail');
            Route::get('/getFile','ListVideoController@getFile')->name('getfile');
            Route::get('/filter','ListVideoController@filter')->name('filter');
        });
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

