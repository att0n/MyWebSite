<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CreateController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //ユーザ新規登録
    public function userCreate(Request $request){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $this->validate($request, [
                'login_id' => 'required',
                'name' => 'required',
                'password1' => 'required|same:password2',
                'password2' => 'required',
                'birth_date' => 'required'
            ]);

            $login_id = $request->input('login_id');
            $name = $request->input('name');
            $pass1 = $request->input('password1');
            $pass2 = $request->input('password2');
            $birth = $request->input('birth_date');

            $user = DB::table('user')->where('login_id', $login_id)->first();
            $today = new Carbon(Carbon::now());
            DB::table('user')->insert(['login_id' => $login_id,'name' => $name,'password' => md5($pass1),'birth_date' => $birth,'create_date' => $today,'update_date' => $today]);
            return view('create');

        }
    }



};