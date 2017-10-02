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

//Route::get('/user', 'Controller@メソッド名');


Route::get('/','Controller@view');

Route::post('main' , 'Controller@login');

Route::get('/logout','Controller@logout');

Route::get('/userList','Controller@userList');

Route::get('/mainScreen', function () {return view('main');});

Route::get('/detail','Controller@userdetail');

Route::get('/create', function () {return view('create');});

Route::post('/userCreate' , 'Controller@userCreate');

Route::get('/update' , 'Controller@update');

Route::post('/userUpdate' , 'Controller@userUpdate');

Route::get('/delete' , 'Controller@userDelete');

Route::get('/characterList' , 'Controller@characterList');

Route::get('/characterDetail' , 'Controller@characterDetail');

Route::get('/gatya' , 'Controller@gatya');

Route::post('/gatyaResult','Controller@gatyaResult');

