<?php 
require_once __DIR__.'/DB_map.class.php';
class Jiancha_and_jiangduo_gr_coef_map extends DB_map {
  static $table_name = 'jiancha_and_jiangduo_gr_coef' ;
  static $jcdws_coef = 'jiancha_and_jiangduo_gr_coef.jcdws_coef' ;
  static $fxhzyhwfxws_coef = 'jiancha_and_jiangduo_gr_coef.fxhzyhwfxws_coef' ;
  static $dczghzyhs_coef = 'jiancha_and_jiangduo_gr_coef.dczghzyhs_coef' ;
  static $xflscfjdss_coef = 'jiancha_and_jiangduo_gr_coef.xflscfjdss_coef' ;
  static $number_id = 'jiancha_and_jiangduo_gr_coef.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
