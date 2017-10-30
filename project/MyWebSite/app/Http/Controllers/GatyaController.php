<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GatyaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //ガチャ
    public function gatya(Request $request){
        if(empty(session('loginUserKey'))){
            return view('welcome',['loginErrorFlag' => false, 'logoutSuccessFlag' => false]);
        }else{
            $id = $request->input('id');
            $cnt = $request->input('num');
            $chara = DB::table('chara')->get();
            $gatya = new gatya();
            $resultArray = array();

            //確立合計値
            $gatya->sumRate();
            $max =  $gatya->getMax();

            //1連
            if($cnt == 1){
                $resultArray[] = $gatya->gatya1($max);
                DB::table('chara_have')->insert(['id' => $id, 'chara_id' => $resultArray[0]->id]);
                $gatya->rarityFlag($resultArray[0]->chara_rate);
            //$cnt連
            }else{
                for($i=0; $i<$cnt; $i++){
                    $resultArray[] = $gatya->gatya1($max);
                    DB::table('chara_have')->insert(['id' => $id, 'chara_id' => $resultArray[$i]->id]);
                    $gatya->rarityFlag($resultArray[$i]->chara_rate);
                }
            }
            $rate = $gatya->rarityCss();
            return view('result' , ['result' => $resultArray,'rate' => $rate]);
        }
    }

    //ガチャ結果画面
    public function gatyaResult(Request $request){
        $resultArray = array();

        if(!empty($request->input('result1'))){
            for($i=0; $i<10; $i++){
                ${'id{$i}'} = $request->input('result'.$i);
                $chara = DB::table('chara')->where('id', ${'id{$i}'})->first();
                $resultArray[] = $chara;
            }
        }else{
            $id1 = $request->input('result0');
            $chara = DB::table('chara')->where('id', $id1)->first();
            $resultArray[] = $chara;
        }

        return view('gatyaResult', ['result' => $resultArray]);
    }

};