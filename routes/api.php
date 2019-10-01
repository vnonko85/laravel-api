<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'ApiUserController@register');

Route::post('/login', 'ApiUserController@login');

Route::post('/movies', 'ApiMoviesController@store');

Route::get('/movies', 'ApiMoviesController@getAll');

Route::get('/movies/{id}', 'ApiMoviesController@getById')->where('id', '\d+');

Route::delete('/movies/{id}', 'ApiMoviesController@deleteById')->where('id', '\d+');

Route::patch('/movies/{id}', 'ApiMoviesController@update')->where('id', '\d+');
