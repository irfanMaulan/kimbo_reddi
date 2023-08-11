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
    return view('auth/login');
});


Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::post('login/post', 'AuthController@login');
    Route::post('logout/post', 'AuthController@logout');
    Route::group(['prefix' => 'dashboard'], function()
    {
        Route::get('/', 'dashboardController@index');
    });

    Route::group(['prefix' => 'data-reedem-hadiah-besar'], function()
    {
        Route::get('/', 'hadiahBesarController@index');
        Route::post('/store', 'hadiahBesarController@store');
    });

    Route::group(['prefix' => 'data-reedem-hadiah-kecil'], function()
    {
        Route::get('/', 'hadiahKecilController@index');
    });

    Route::group(['prefix' => 'list-download'], function()
    {
        Route::get('/', 'listDownloadController@index');
        Route::post('/post', 'listDownloadController@post');
    });

    Route::group(['prefix' => 'ringkasan-hadiah'], function()
    {
        Route::get('/', 'ringkasanHadiahController@index');
        Route::post('/store', 'ringkasanHadiahController@index');
    });

    Route::group(['prefix' => 'program'], function()
    {
        Route::get('/', 'programController@index');
        Route::POST('/update', 'programController@put');
    });

    Route::group(['prefix' => 'kode-unik'], function()
    {
        Route::get('/', 'kodeUniqController@index');
        Route::post('/update', 'kodeUniqController@put');
    });

    Route::group(['prefix' => 'user-management'], function()
    {
        Route::get('/', 'userManagementController@index');
        Route::post('/store', 'userManagementController@store');
        Route::post('/put', 'userManagementController@put');
        Route::post('/delete', 'userManagementController@delete');
    });

    Route::group(['prefix' => 'generate-code'], function()
    {
        Route::get('/', 'generateCodeController@index');
    });

    Route::group(['prefix' => 'uniq-code-generate'], function()
    {
        Route::get('/', 'uniqCodeGenerateController@index');
        Route::post('/store', 'uniqCodeGenerateController@store');
    });

    Route::get('/download/{url}', function($url){
        $url = decrypt($url);
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($url) . "\"");
        return readfile($url);
    });
});
