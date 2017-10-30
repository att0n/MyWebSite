<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class gatya extends BaseController{
    protected $max;
    protected $ssr = false;
    protected $sr = false;
    protected $r = false;
    protected $rate;

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
     * @return $rate
     */
    public function getRate()
    {
        return $this->rate;
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

    /**
     * @param boolean $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    //合計値計算
    public function sumRate(){
        $chara = DB::table('chara')->get();
        self::setMax(0);
        foreach ($chara as $chara_rate){
            $max = self::getMax();

            if($chara_rate->chara_rate==3){
                $max+=5;
            }elseif ($chara_rate->chara_rate==2){
                $max+=30;
            }else{
                $max+=100;
            }
            self::setMax($max);
        }
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

    //レアリティフラグ
    public function rarityFlag($chara_rarity){
        if($chara_rarity==3){
            self::setSsr(true);
        }else if($chara_rarity==2){
            self::setSr(true);
        }else{
            self::setR(true);
        }
    }

    //レアリティ演出
    public function rarityCss(){
        if(self::getSsr()==true){
            return 'ssr';
        }else if(self::getSsr()==false && self::getSr()==true){
            return 'sr';
        }else{
            return 'r';
        }
    }

}