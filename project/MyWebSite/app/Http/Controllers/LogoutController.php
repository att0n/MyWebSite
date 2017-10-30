<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LogoutController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //ログアウト処理
    public function logout(){
        $loginErrorFlag = false;
        $logoutSuccessFlag = true;
        session()->forget('loginUserKey');
        return view('welcome',['loginErrorFlag' => $loginErrorFlag, 'logoutSuccessFlag' => $logoutSuccessFlag]);
    }


};