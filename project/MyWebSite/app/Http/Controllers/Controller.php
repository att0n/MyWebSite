<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(){
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
            // セッションデータ保存
            session(['loginUserKey' => $loginUser]);
            return view('main');
        }
    }

    //ログアウト処理
    public function logout(){
        session()->forget('loginUserKey');
        return view('welcome');
    }

    //ユーザ一覧
    public function userList(){
        $userList = DB::table('user')->where('id','!=','1')->get();
        return view('userList',['userList' => $userList]);
    }

    //ユーザ詳細表示
    public function userDetail(){
        $user_id = $_GET['id'];
        $user = DB::table('user')->where('id', $user_id)->first();

        $birth = date('Y年m月d日', strtotime($user->birth_date));
        $create = date('Y年m月d日 H時i分s秒', strtotime($user->create_date));
        $update = date('Y年m月d日 H時i分s秒', strtotime($user->update_date));
        $user->birth_date = $birth;
        $user->create_date = $create;
        $user->update_date = $update;

        return view('detail',['user' => $user]);
    }

    //ユーザ新規登録
    public function userCreate(){
        $login_id = $_POST['login_id'];
        $name = $_POST['name'];
        $pass1 = $_POST['password1'];
        $pass2 = $_POST['password2'];
        $birth = $_POST['birth_date'];

        $user = DB::table('user')->where('login_id', $login_id)->first();

        if(empty($login_id) || empty($name) || empty($pass1) || empty($pass2) || empty($birth)){
            print_r("未入力項目在り");
        }else if ($pass1 != $pass2){
            print_r("passの不一致");
        }else if(isset($user)){
            print_r("loginIDの重複");
        }else{
            $today = new Carbon(Carbon::now());
            DB::table('user')->insert(['login_id' => $login_id,'name' => $name,'password' => md5($pass1),'birth_date' => $birth,'create_date' => $today,'update_date' => $today]);
        }
        return view('main');
    }

    //ユーザ更新画面表示
    public function update(){
        $loginUser_id = $_GET['id'];
        $user = DB::table('user')->where('id', $loginUser_id)->first();
        return view('update',['user' => $user]);
    }

    //ユーザ更新
    public function userUpdate(){
        $id = $_GET['id'];
        $pass1 = $_POST['pass'];
        $pass2 = $_POST['pass2'];
        $name = $_POST['name'];
        $birth = $_POST['birth'];
        $today = new Carbon(Carbon::now());

        if(!empty($pass1) && !empty($pass2) && !empty($name) && !empty($birth)){
            if($pass1 == $pass2){
                $passMd5 = md5($pass1);
                DB::update('UPDATE user SET name=?,birth_date=?,update_date=?,password=? WHERE id=?',[$name,$birth,$today,$passMd5,$id]);
            }
        }else if (empty($pass1) && empty($pass2) && !empty($name) && !empty($birth)){
            DB::update('UPDATE user SET name=?,birth_date=?,update_date=? WHERE id=?',[$_POST['name'],$_POST['birth'],$today,$id]);
        }
        return view('main');
    }

    //ユーザの削除
    public function userDelete(){
        $id = $_GET['id'];
        DB::table('user')->where('id', $id)->delete();
        return view('main');
    }

    //キャラクターリスト表示
    public function characterList(){
        $chara = DB::table('chara')->get();

        return view('characterList', ['chara' => $chara]);
    }

    //キャラクター詳細
    public function characterDetail(){
        $chara_id = $_GET['id'];
        $chara = DB::table('chara')->where('id', $chara_id)->first();

        return view('characterDetail', ['chara' => $chara]);
    }

    //ガチャ
    public function gatya(){
        $cnt = $_GET['num'];
        $chara = DB::table('chara')->get();
        $resultArray = array();
        $ssr = false;
        $sr = false;
        $r = false;

        if($cnt == 1){
            $hitkey = rand(0, count($chara)-1);
            $resultArray[] = $chara[$hitkey];

            if($resultArray[0]->chara_rate == 3){$ssr = true;
            }elseif ($resultArray[0]->chara_rate == 2){$sr = true;
            }else{$r = true;}
        }else{
            for($i=0; $i<10; $i++){
                $hitkey = rand(0, count($chara)-1);
                $resultArray[] = $chara[$hitkey];
            }
            for ($i=0; $i<$cnt; $i++){
                if($resultArray[$i]->chara_rate == 3){$ssr = true;
                }else if($resultArray[$i]->chara_rate == 2){$sr = true;
                }else {$r = true;}
            }
        }
        if($ssr == true){$rate ="ssr";
        }elseif ($ssr == false && $sr == true){$rate = "sr";
        }else{$rate = "r";}

        return view('result' , ['result' => $resultArray,'rate' => $rate]);
    }

    //ガチャ結果画面
    public function gatyaResult(){
        $resultArray = array();

        if(!empty($_POST['result1'])){
            for($i=0; $i<10; $i++){
                ${'id{$i}'} = $_POST['result'.$i];
                $chara = DB::table('chara')->where('id', ${'id{$i}'})->first();
                $resultArray[] = $chara;
            }
        }else{
            $id1 = $_POST['result0'];
            $chara = DB::table('chara')->where('id', $id1)->first();
            $resultArray[] = $chara;
        }

        return view('gatyaResult', ['result' => $resultArray]);
    }
}
