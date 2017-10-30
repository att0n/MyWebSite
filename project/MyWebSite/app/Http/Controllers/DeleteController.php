<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //ユーザの削除
    public function userDelete(Request $request){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $id = $request->input('id');

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

};