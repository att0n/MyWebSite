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

            $gatya = new gatya();

            $id = $request->input('id');
            $cnt = $request->input('num');
            $chara = DB::table('chara')->get();
            $resultArray = array();
            $ssr = false;
            $sr = false;
            $r = false;

            //確立の合計値
            $gatya->setMax(0);       //max=0
            foreach ($chara as $chara_rate){
                $num = $gatya->maxRate($chara_rate->chara_rate,$gatya->getMax());
                $gatya->setMax($num);
            }
            $max = $gatya->getMax();

            if($cnt == 1){

                $resultArray[] = $gatya->gatya1($max);
                DB::table('chara_have')->insert(['id' => $id, 'chara_id' => $resultArray[0]->id]);

                if($resultArray[0]->chara_rate == 3){$ssr = true;
                }elseif ($resultArray[0]->chara_rate == 2){$sr = true;
                }else{$r = true;}
            }else{
                for($i=0; $i<10; $i++){
                    $resultArray[] = $gatya->gatya1($max);
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