<?php 
require_once __DIR__.'/DB_map.class.php';
class Zfzl_flws_gr_map extends DB_map {
  static $table_name = 'zfzl_flws_gr' ;
  static $police_name = 'zfzl_flws_gr.police_name' ;
  static $dd_name = 'zfzl_flws_gr.dd_name' ;
  static $zhd_name = 'zfzl_flws_gr.zhd_name' ;
  static $year_month_show = 'zfzl_flws_gr.year_month_show' ;
  static $wh = 'zfzl_flws_gr.wh' ;
  static $ItemName = 'zfzl_flws_gr.ItemName' ;
  static $ItemBH = 'zfzl_flws_gr.ItemBH' ;
  static $FlwsID = 'zfzl_flws_gr.FlwsID' ;
  static $Flwslb = 'zfzl_flws_gr.Flwslb' ;
  static $state = 'zfzl_flws_gr.state' ;
  static $isRepeal = 'zfzl_flws_gr.isRepeal' ;
  static $IsSd = 'zfzl_flws_gr.IsSd' ;
  static $IsHg = 'zfzl_flws_gr.IsHg' ;
  static $IsFj = 'zfzl_flws_gr.IsFj' ;
  static $IsGg = 'zfzl_flws_gr.IsGg' ;
  static $FilePath = 'zfzl_flws_gr.FilePath' ;
  static $AppAcc = 'zfzl_flws_gr.AppAcc' ;
  static $AppAccName = 'zfzl_flws_gr.AppAccName' ;
  static $AppTime = 'zfzl_flws_gr.AppTime' ;
  static $Acc = 'zfzl_flws_gr.Acc' ;
  static $AccName = 'zfzl_flws_gr.AccName' ;
  static $InTime = 'zfzl_flws_gr.InTime' ;
  static $number_id = 'zfzl_flws_gr.number_id' ;
  static $score = 'zfzl_flws_gr.score' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
