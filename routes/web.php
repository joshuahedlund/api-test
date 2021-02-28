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
    Route::get('/profile/{id}', ['as' => 'profile.show', 'uses' => 'ProfilesController@show']);
    Route::get('/interaction/{id}', ['as' => 'interaction.show', 'uses' => 'InteractionsController@show']);

    Route::get('/profiles/list', ['as' => 'profile.index', 'uses' => 'ProfilesController@index']);

    Route::post('/profiles/create', ['as' => 'profile.create', 'uses' => 'ProfilesController@create']);
    Route::post('/profile/{id}/update', ['as' => 'profile.update', 'uses' => 'ProfilesController@update']);
    Route::post('/profile/{id}/delete', ['as' => 'profile.delete', 'uses' => 'ProfilesController@delete']);
    Route::post('/profile/{id}/create-interaction', ['as' => 'interaction.create', 'uses' => 'InteractionsController@create']);
});

Route::fallback(function(){
    return response()->json(['error' => 'Invalid endpoint'],404);
});
