<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group( ['middleware' => ['auth:api']], function()
{   
    Route::get('/users','App\Http\Controllers\UserController@users');
    Route::resource('/user','App\Http\Controllers\UserController');
    Route::get('/checkAuth','App\Http\Controllers\AuthController@checkAuth');

    
    Route::get('/roles','App\Http\Controllers\RoleController@roles');

    Route::put('/change-email','App\Http\Controllers\AuthController@changeEmail');
    Route::put('/change-phone','App\Http\Controllers\AuthController@changePhone');

    Route::post('/confirm-email','App\Http\Controllers\AuthController@confirmEmail');
    Route::put('/update-user-profile','App\Http\Controllers\AuthController@updateUserProfile');
    Route::post('/confirm-phone','App\Http\Controllers\AuthController@confirmPhone');

});

Route::post('/login','App\Http\Controllers\AuthController@login');

Route::post('/reset','App\Http\Controllers\AuthController@reset');
Route::post('/reset/save','App\Http\Controllers\AuthController@resetSave');
Route::post('/updatePassword','App\Http\Controllers\AuthController@updatePassword')->middleware('auth:api');
Route::get('/logout','App\Http\Controllers\AuthController@logout');