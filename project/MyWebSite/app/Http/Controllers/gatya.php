<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class gatya extends BaseController{
    protected $max;
    protected $ssr = false;
    protected $sr = false;
    protected $r = false;
    /**
     * @return $max
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return $ssr
     */
    public function getSsr()
    {
        return $this->ssr;
    }

    /**
     * @return $sr
     */
    public function getSr()
    {
        return $this->sr;
    }

    /**
     * @return $r
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * @param field_type $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * @param boolean $ssr
     */
    public function setSsr($ssr)
    {
        $this->ssr = $ssr;
    }

    /**
     * @param boolean $sr
     */
    public function setSr($sr)
    {
        $this->sr = $sr;
    }

    /**
     * @param boolean $r
     */
    public function setR($r)
    {
        $this->r = $r;
    }

    //確立を足す
    public function maxRate($num,$max){
        if($num==3){
            $max+=5;
        }else if($num==2){
            $max+=30;
        }else{
            $max+=100;
        }
        return $max;
    }

    //確立でキャラクターを排出する
    public function gatya1($max){
        $chara = DB::table('chara')->get();

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
        return $hitChara;
    }


}