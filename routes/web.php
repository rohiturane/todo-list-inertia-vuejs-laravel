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

Route::get('/', 'WelcomeController@index');
Route::get('/todolist','WelcomeController@todoList');
Route::post('/store/todo','WelcomeController@store');
Route::post('/status/todo','WelcomeController@updateStatus');
Route::post('/update/{id}/todo','WelcomeController@update');
Route::post('/delete/todo','WelcomeController@destory');