<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(){
        $loginErrorFlag = false;
        $logoutSuccessFlag = false;
        return view('welcome',['loginErrorFlag' => $loginErrorFlag, 'logoutSuccessFlag' => $logoutSuccessFlag]);
    }

    //POST時ログイン処理
    public function login()
    {
        // パラメータ取得
        $login_id = $_POST['login_id'];
        $pass = md5($_POST['pass']);
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

    //ログアウト処理
    public function logout(){
        $loginErrorFlag = false;
        $logoutSuccessFlag = true;
        session()->forget('loginUserKey');
        return view('welcome',['loginErrorFlag' => $loginErrorFlag, 'logoutSuccessFlag' => $logoutSuccessFlag]);
    }

    //ユーザ一覧
    public function userList(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $all_chara = DB::table('chara')->count();
            $collection = collect(['1' => 'admin']);
            $userList = DB::table('user')->where('id','!=','1')->get();

            for($i=0; $i<count($userList); $i++){
                $chara = DB::table('chara_have')
                ->join('chara','chara_have.chara_id','=','chara.id')
                ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
                ->where('chara_have.id',$userList[$i]->id)
                ->groupBy('chara_have.chara_id')
                ->get();

                $collection->put($userList[$i]->id, $chara->count());
            }

            return view('userList',['userList' => $userList, 'all_chara' => $all_chara, 'have_chara' => $collection]);

        }
    }

    //ユーザ詳細表示
    public function userDetail(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $all_chara = DB::table('chara')->count();
            $user_id = $_GET['id'];
            $user = DB::table('user')->where('id', $user_id)->first();

            $birth = date('Y年m月d日', strtotime($user->birth_date));
            $create = date('Y年m月d日 H時i分s秒', strtotime($user->create_date));
            $update = date('Y年m月d日 H時i分s秒', strtotime($user->update_date));
            $user->birth_date = $birth;
            $user->create_date = $create;
            $user->update_date = $update;

            $chara = DB::table('chara_have')
            ->join('chara','chara_have.chara_id','=','chara.id')
            ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
            ->where('chara_have.id', $user_id)
            ->groupBy('chara_have.chara_id')
            ->get();

            return view('detail',['user' => $user, 'all_chara' => $all_chara ,'have_chara' => $chara->count()]);
        }
    }

    //ユーザ新規登録
    public function userCreate(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $login_id = $_POST['login_id'];
            $name = $_POST['name'];
            $pass1 = $_POST['password1'];
            $pass2 = $_POST['password2'];
            $birth = $_POST['birth_date'];
            $userCreateFlag =0;

            $user = DB::table('user')->where('login_id', $login_id)->first();

            if(empty($login_id) || empty($name) || empty($pass1) || empty($pass2) || empty($birth)){
                $userCreateFlag=1;
            }else if ($pass1 != $pass2){
                $userCreateFlag=2;
            }else if(isset($user)){
                $userCreateFlag=3;
            }else{
                $today = new Carbon(Carbon::now());
                DB::table('user')->insert(['login_id' => $login_id,'name' => $name,'password' => md5($pass1),'birth_date' => $birth,'create_date' => $today,'update_date' => $today]);
                $userCreateFlag=4;
            }
            return view('create',['userCreateFlag' => $userCreateFlag]);
        }
    }

    //ユーザ更新画面表示
    public function update(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $loginUser_id = $_GET['id'];
            $user = DB::table('user')->where('id', $loginUser_id)->first();
            return view('update',['user' => $user,'errorFlag' => false]);
        }
    }

    //ユーザ更新
    public function userUpdate(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $id = $_GET['id'];
            $pass1 = $_POST['pass'];
            $pass2 = $_POST['pass2'];
            $name = $_POST['name'];
            $birth = $_POST['birth'];
            $today = new Carbon(Carbon::now());
            $errorFlag = false;

            if(!empty($pass1) && !empty($pass2) && !empty($name) && !empty($birth)){
                if($pass1 == $pass2){
                    $passMd5 = md5($pass1);
                    DB::update('UPDATE user SET name=?,birth_date=?,update_date=?,password=? WHERE id=?',[$name,$birth,$today,$passMd5,$id]);
                }
            }else if (empty($pass1) && empty($pass2) && !empty($name) && !empty($birth)){
                DB::update('UPDATE user SET name=?,birth_date=?,update_date=? WHERE id=?',[$_POST['name'],$_POST['birth'],$today,$id]);
            }else{
                $errorFlag = true;
            }
            $user = DB::table('user')->where('id', $id)->first();
            return view('update',['user' => $user,'errorFlag' => $errorFlag]);
        }
    }

    //ユーザの削除
    public function userDelete(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $id = $_GET['id'];
            DB::table('user')->where('id', $id)->delete();

            $all_chara = DB::table('chara')->count();
            $collection = collect(['1' => 'admin']);
            $userList = DB::table('user')->where('id','!=','1')->get();

            for($i=0; $i<count($userList); $i++){
                $chara = DB::table('chara_have')
                ->join('chara','chara_have.chara_id','=','chara.id')
                ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
                ->where('chara_have.id',$userList[$i]->id)
                ->groupBy('chara_have.chara_id')
                ->get();

                $collection->put($userList[$i]->id, $chara->count());
            }

            return view('userList',['userList' => $userList, 'all_chara' => $all_chara, 'have_chara' => $collection]);
        }
    }

    //キャラクターリスト表示
    public function characterList(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $searchFlag = false;
            $userID = $_GET['id'];

            $all_chara = DB::table('chara')->count();

            $chara = DB::table('chara_have')
            ->join('chara','chara_have.chara_id','=','chara.id')
            ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
            ->where('chara_have.id',$userID)
            ->groupBy('chara_have.chara_id')
            ->orderBy('chara_id', 'asc')
            ->get();

            return view('characterList', ['chara' => $chara,'all_chara' => $all_chara,'searchFlag' => $searchFlag]);
        }
    }

    //キャラクター詳細
    public function characterDetail(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $user_id = $_GET['uId'];
            $chara_id = $_GET['id'];

            $chara = DB::table('chara_have')
            ->join('chara','chara_have.chara_id','=','chara.id')
            ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
            ->where([
                ['chara_have.id', '=', $user_id],
                ['chara_have.chara_id', '=', $chara_id]
            ])
            ->groupBy('chara_have.chara_id')
            ->first();

            return view('characterDetail', ['chara' => $chara]);
        }
    }

    //ガチャ
    public function gatya(){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $id = $_GET['id'];
            $cnt = $_GET['num'];
            $chara = DB::table('chara')->get();
            $resultArray = array();
            $ssr = false;
            $sr = false;
            $r = false;

            //確立の合計値
            $max = 0;
            foreach ($chara as $chara_rate){
                if($chara_rate->chara_rate==3){$max += 5;
                }elseif ($chara_rate->chara_rate==2){$max += 30;
                }else {$max += 100;}
            }

            if($cnt == 1){
                $hitRand = rand(0,$max-1);
                $sumPer = 0;

                for($i=0; $i<count($chara); $i++){
                    if($chara[$i]->chara_rate==3){$sumPer += 5;
                    }elseif ($chara[$i]->chara_rate==2){$sumPer += 30;
                    }else {$sumPer += 100;}
                    $hitChara = $chara[$i];
                    if($hitRand < $sumPer){
                        break;
                    }
                }

                $resultArray[] = $hitChara;
                DB::table('chara_have')->insert(['id' => $id, 'chara_id' => $resultArray[0]->id]);

                if($resultArray[0]->chara_rate == 3){$ssr = true;
                }elseif ($resultArray[0]->chara_rate == 2){$sr = true;
                }else{$r = true;}
            }else{
                for($i=0; $i<10; $i++){
                    $hitRand = rand(0,$max-1); //echo $hitRand;
                    $sumPer = 0;

                    for($j=0; $j<count($chara); $j++){
                        if($chara[$j]->chara_rate==3){$sumPer += 5;
                        }elseif ($chara[$j]->chara_rate==2){$sumPer += 30;
                        }else {$sumPer += 100;}
                        $hitChara = $chara[$j];
                        if($hitRand < $sumPer){
                            break;
                        }
                    }
                    $resultArray[] = $hitChara;

                }
                for ($i=0; $i<$cnt; $i++){
                    DB::table('chara_have')->insert(['id' => $id, 'chara_id' => $resultArray[$i]->id]);

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

    //キャラクターID検索
    public function searchCharaID(){
        $charaID = $_POST['chara_id'];
        $userID = $_GET['userID'];
        $all_chara = DB::table('chara')->count();

        if($charaID==""){

            $searchFlag = false;
            $chara = DB::table('chara_have')
            ->join('chara','chara_have.chara_id','=','chara.id')
            ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
            ->where('chara_have.id',$userID)
            ->groupBy('chara_have.chara_id')
            ->get();

            return view('characterList', ['chara' => $chara,'all_chara' => $all_chara,'searchFlag' => $searchFlag]);
        }else{

            $searchFlag = true;
            $chara = DB::table('chara_have')
            ->join('chara','chara_have.chara_id','=','chara.id')
            ->select('chara.chara_image', 'chara_have.chara_id')
            ->groupBy('chara_have.chara_id')
            ->where([
                ['chara_have.chara_id','=',$charaID],
                ['chara_have.id','=',$userID]
            ])->get();

            return view('characterList', ['chara' => $chara,'all_chara' => $all_chara,'searchFlag' => $searchFlag]);
        }
    }

    //キャラクター名検索
    public function searchCharaName(){
        $charaName = $_POST['chara_name'];
        $userID = $_GET['userID'];
        $all_chara = DB::table('chara')->count();

        if($charaName==""){

            $searchFlag = false;
            $chara = DB::table('chara_have')
            ->join('chara','chara_have.chara_id','=','chara.id')
            ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
            ->where('chara_have.id',$userID)
            ->groupBy('chara_have.chara_id')
            ->get();

            return view('characterList', ['chara' => $chara,'all_chara' => $all_chara,'searchFlag' => $searchFlag]);
        }else{

            $searchFlag = true;
            $chara = DB::table('chara_have')
            ->join('chara','chara_have.chara_id','=','chara.id')
            ->select('chara.chara_image', 'chara_have.chara_id')
            ->groupBy('chara_have.chara_id')
            ->where([
                ['chara_have.id','=',$userID],
                ['chara.chara_name','like','%'.$charaName.'%']
            ])->get();

            return view('characterList', ['chara' => $chara,'all_chara' => $all_chara,'searchFlag' => $searchFlag]);
        }
    }

    //レアリティ検索
    public function searchRarity(){
        $userID = session('loginUserKey')->id;
        $rarity = $_GET['rarity'];
        $searchFlag = true;

        $chara = DB::table('chara_have')
        ->join('chara','chara_have.chara_id','=','chara.id')
        ->select('chara.chara_image', 'chara_have.chara_id')
        ->groupBy('chara_have.chara_id')
        ->where([
            ['chara_have.id','=',$userID],
            ['chara.chara_rate','=', $rarity]
        ])->get();

        return view('characterList', ['chara' => $chara,'searchFlag' => $searchFlag]);
    }

    //キャラクターの追加
    public function addChara(Request $request){
        $chara_rarity = $_POST['chara_rarity'];
        $chara_name = $_POST['chara_name'];
        $chara_birth = $_POST['chara_birth'];
        $chara_blood = $_POST['chara_blood'];


         if($chara_name=="" || $chara_birth==""){
             $addFlag = 1;
         }else{
             if ($request->hasFile('chara_image1')) {
                 $addFlag = 2;
                 $n1 = $request->chara_image1->getClientOriginalName();
                 $request->chara_image1->storeAs('images/01', $n1);
                 $image_name = Storage::url('images/01/ssr2.png');

                 DB::table('chara')->insert(['chara_rate' => $chara_rarity, 'chara_image' => $image_name, 'chara_name' => $chara_name, 'chara_birth' => $chara_birth, 'chara_blood' => $chara_blood]);
             }else{
                 $addFlag = 3;
             }
         }
         return view('characterCreate', ['addFlag' => $addFlag]);
    }

    //達成率リセット
    public function reset(){
        $user_id = $_GET['id'];
        DB::table('chara_have')->where('id', '=', $user_id)->delete();

        $all_chara = DB::table('chara')->count();
        $user_id = $_GET['id'];
        $user = DB::table('user')->where('id', $user_id)->first();

        $birth = date('Y年m月d日', strtotime($user->birth_date));
        $create = date('Y年m月d日 H時i分s秒', strtotime($user->create_date));
        $update = date('Y年m月d日 H時i分s秒', strtotime($user->update_date));
        $user->birth_date = $birth;
        $user->create_date = $create;
        $user->update_date = $update;

        $chara = DB::table('chara_have')
        ->join('chara','chara_have.chara_id','=','chara.id')
        ->select(DB::raw('count(*) as cnt, chara.*, chara_have.*'))
        ->where('chara_have.id', $user_id)
        ->groupBy('chara_have.chara_id')
        ->get();

        return view('detail',['user' => $user, 'all_chara' => $all_chara ,'have_chara' => $chara->count()]);
    }
}

