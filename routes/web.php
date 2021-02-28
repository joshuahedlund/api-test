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
    return response()->json(['status' => 'on']);
});

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('/profile/{id}','ProfilesController@show');
    Route::get('/interaction/{id}','InteractionsController@show');

    Route::get('/profiles/list', 'ProfilesController@index');

    Route::post('/profiles/create','ProfilesController@create');
    Route::post('/profile/{id}/update','ProfilesController@update');
    Route::post('/profile/{id}/delete','ProfilesController@delete');
    Route::post('/profile/{id}/create-interaction','InteractionsController@create');
});

Route::fallback(function(){
    return response()->json(['error' => 'Invalid endpoint'],404);
});
