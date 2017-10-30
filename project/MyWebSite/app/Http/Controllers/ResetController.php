<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ResetController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //達成率リセット
    public function reset(Request $request){

        $user_id = $request->input('id');
        DB::table('chara_have')->where('id', '=', $user_id)->delete();

        $all_chara = DB::table('chara')->count();
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

};