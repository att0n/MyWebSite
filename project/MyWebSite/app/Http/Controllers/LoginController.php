<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //POST時ログイン処理
    public function login(Request $request){

        $this->validate($request, [
            'login_id' => 'required',
            'pass' => 'required'
        ]);

        // パラメータ取得
        $login_id = $request->input('login_id');
        $pass = md5($request->input('pass'));
        // レコード確認
        $cnt = DB::select('SELECT count(*) AS cnt FROM user WHERE login_id = ? AND password = ?', [$login_id,$pass]);
        if ($cnt[0]->cnt == 0) {
            $loginErrorFlag = true;
            $logoutSuccessFlag = false;
            return view('welcome',['loginErrorFlag' => $loginErrorFlag, 'logoutSuccessFlag' => $logoutSuccessFlag]);
        } else {
            $loginUser = DB::table('user')->select('id', 'login_id', 'name')
            ->where('login_id', $login_id)
            ->where('password', $pass)
            ->first();
            // セッションデータ保存
            session(['loginUserKey' => $loginUser]);
            return view('main');
        }
    }


    //GET時ログイン処理
    public function login2(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            return view('main');
        }
    }
};