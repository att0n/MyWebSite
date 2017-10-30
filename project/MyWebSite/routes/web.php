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

Route::post('/main' , 'LoginController@login');

Route::get('/main','LoginController@login2');

Route::get('/logout','LogoutController@logout');

Route::get('/userList','ListController@userList');

Route::get('/mainScreen', function () {
    if(empty(session('loginUserKey'))){
        return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
    }else{
        return view('main');
    }
});

Route::get('/detail','DetailController@userdetail');

Route::get('/create', function () {
    if(empty(session('loginUserKey'))){
        return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
    }else{
        return view('create',['userCreateFlag' => 0]);
    }
});

Route::post('/userCreate' , 'CreateController@userCreate');

Route::get('/update' , 'UpdateController@update');

Route::post('/userUpdate' , 'UpdateController@userUpdate');

Route::get('/delete' , 'DeleteController@userDelete');

Route::get('/characterList' , 'ListController@characterList');

Route::get('/characterDetail' , 'DetailController@characterDetail');

Route::get('/gatya' , 'GatyaController@gatya');

Route::post('/gatyaResult','GatyaController@gatyaResult');

Route::post('/characterSearchID','SearchController@searchCharaID');

Route::post('/characterSearchName','SearchController@searchCharaName');

Route::get('/searchRarity' , 'SearchController@searchRarity');

Route::get('/characterCreate' , function () {
    if(empty(session('loginUserKey'))){
        return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
    }else{
        return view('characterCreate', ['addFlag' => 0]);
    }
});

Route::post('/addChara','AddController@addChara');

Route::get('/reset' , 'ResetController@reset');
