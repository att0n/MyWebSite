<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //キャラクターID検索
    public function searchCharaID(Request $request){
        $charaID = $request->input('chara_id');
        $userID = $request->input('userID');
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
    public function searchCharaName(Request $request){
        $charaName = $request->input('chara_name');
        $userID = $request->input('userID');
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
    public function searchRarity(Request $request){
        $userID = session('loginUserKey')->id;
        $rarity = $request->input('rarity');
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

};