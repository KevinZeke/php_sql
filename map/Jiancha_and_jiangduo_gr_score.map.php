<?php 
require_once __DIR__.'/DB_map.class.php';
class Jiancha_and_jiangduo_gr_score_map extends DB_map {
  static $table_name = 'jiancha_and_jiangduo_gr_score' ;
  static $police_id = 'jiancha_and_jiangduo_gr_score.police_id' ;
  static $police_name = 'jiancha_and_jiangduo_gr_score.police_name' ;
  static $dd_name = 'jiancha_and_jiangduo_gr_score.dd_name' ;
  static $zhd_name = 'jiancha_and_jiangduo_gr_score.zhd_name' ;
  static $year_month_show = 'jiancha_and_jiangduo_gr_score.year_month_show' ;
  static $JCDWS_SCORE = 'jiancha_and_jiangduo_gr_score.JCDWS_SCORE' ;
  static $FXHZYHWFXWS_SCORE = 'jiancha_and_jiangduo_gr_score.FXHZYHWFXWS_SCORE' ;
  static $DCZGHZYHS_SCORE = 'jiancha_and_jiangduo_gr_score.DCZGHZYHS_SCORE' ;
  static $XFLSCFJDSS_SCORE = 'jiancha_and_jiangduo_gr_score.XFLSCFJDSS_SCORE' ;
  static $jcjd_zdf = 'jiancha_and_jiangduo_gr_score.jcjd_zdf' ;
  static $Rank = 'jiancha_and_jiangduo_gr_score.Rank' ;
  static $Total_staff_nbr = 'jiancha_and_jiangduo_gr_score.Total_staff_nbr' ;
  static $number_id = 'jiancha_and_jiangduo_gr_score.number_id' ;
  static function all(){
            //return parent::all();
        }
}
