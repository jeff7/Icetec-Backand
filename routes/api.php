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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('Api')->group(function(){

    Route::post('login', 'Auth\\LoginJwtController@login')->name('login');
    Route::get('logout', 'Auth\\LoginJwtController@logout')->name('logout');
    Route::get('refresh', 'Auth\\LoginJwtController@refresh')->name('refresh');

    Route::name('users')->group(function(){
        Route::resource('users', 'UserController');
    });    
    Route::group(['middleware' => ['jwt.auth']],function () {

        Route::get('/search', 'CandidateSearchController@index')->name('search');
        Route::get('/search/{candidate_id}', 'CandidateSearchController@show')->name('search_single');

        Route::name('candidates')->group(function(){
            // Route::get('candidates/{id}/candidate', 'CategoryController@realstates');
            Route::resource('candidates', 'CandidateController');
        });

    });
}
);