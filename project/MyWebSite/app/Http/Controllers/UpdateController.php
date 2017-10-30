<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //ユーザ更新画面表示
    public function update(Request $request){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $loginUser_id = $request->input('id');
            $user = DB::table('user')->where('id', $loginUser_id)->first();
            return view('update',['user' => $user,'errorFlag' => false]);
        }
    }

    //ユーザ更新
    public function userUpdate(Request $request){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $this->validate($request, [
                'pass' => 'same:pass2'
            ]);

            $id = $request->input('id');
            $pass1 = $request->input('pass');
            $pass2 = $request->input('pass2');
            $name = $request->input('name');
            $birth = $request->input('birth');
            $today = new Carbon(Carbon::now());
            $errorFlag = false;

            if(!empty($pass1) && !empty($pass2) && !empty($name) && !empty($birth)){
                $passMd5 = md5($pass1);
                DB::update('UPDATE user SET name=?,birth_date=?,update_date=?,password=? WHERE id=?',[$name,$birth,$today,$passMd5,$id]);
            }else if (empty($pass1) && empty($pass2) && !empty($name) && !empty($birth)){
                DB::update('UPDATE user SET name=?,birth_date=?,update_date=? WHERE id=?',[$name,$birth,$today,$id]);
            }else{
                $errorFlag = true;
            }
            $user = DB::table('user')->where('id', $id)->first();
            return view('update',['user' => $user,'errorFlag' => $errorFlag]);
        }
    }

};