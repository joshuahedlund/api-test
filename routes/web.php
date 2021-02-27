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
    return view('welcome');
});

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('/profile/{id}','ProfilesController@show');
    Route::get('/interaction/{id}','InteractionsController@show');

    Route::get('/profiles/list', 'ProfilesController@index');

    //todo change these to post
    Route::get('/profiles/create','ProfilesController@create');
    Route::get('/profiles/update/{id}','ProfilesController@update');
    Route::get('/profiles/delete/{id}','ProfilesController@delete');

    Route::get('/profile/{id}/create-interaction','InteractionsController@create');
});

Route::fallback(function(){
    return response()->json(['error' => 'Invalid endpoint']);
});
