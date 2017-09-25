<?php

use App\Http\Controllers\Controller;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/user', 'UsersController@メソッド名');


Route::get('/','Controller@listAll');

Route::post('main' , 'Controller@login');

Route::get('/logout','Controller@logout');
