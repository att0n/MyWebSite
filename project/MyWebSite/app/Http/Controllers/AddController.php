<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AddController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //キャラクターの追加
    public function addChara(Request $request){

        $this->validate($request, [
            'chara_name' => 'required',
            'chara_image1' => 'required|image',
            'chara_birth' => 'required'
        ]);

        $chara_rarity = $request->input('chara_rarity');
        $chara_name = $request->input('chara_name');
        $chara_birth = $request->input('chara_birth');
        $chara_blood = $request->input('chara_blood');

        $n1 = $request->chara_image1->getClientOriginalName();
        $request->chara_image1->storeAs('images/01', $n1);
        $image_name = Storage::url('images/01/ssr2.png');

        DB::table('chara')->insert(['chara_rate' => $chara_rarity, 'chara_image' => $image_name, 'chara_name' => $chara_name, 'chara_birth' => $chara_birth, 'chara_blood' => $chara_blood]);

        return view('characterCreate');
    }

};