<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function listAll()
    {
        // userテーブルのレコードを全て取得
        //$users = DB::table('user');

        //['users' => $users]
        return view('welcome');
    }

    // ログイン処理
    public function login()
    {
        // パラメータ取得
        $login_id = $_POST['login_id'];
        $pass = md5($_POST['pass']);

        // レコード確認
        $cnt = DB::select('SELECT count(*) AS cnt FROM user WHERE login_id = ? AND password = ?', [$login_id,$pass]);

        if ($cnt[0]->cnt == 0) {
            print_r("login失敗");
            return view('welcome');
        } else {
            $loginUser = DB::table('user')->select('id', 'login_id', 'name')
                ->where('login_id', $login_id)
                ->where('password', $pass)
                ->first();

            // セッションデータを保存する
            session(['loginUserKey' => $loginUser]);

            return view('main');
        }

    }

    //ログアウト処理
    public function logout(){
        session()->flush();
        return view('welcome');
    }
}
