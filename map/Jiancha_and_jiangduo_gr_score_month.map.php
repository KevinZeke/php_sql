<?php 
require_once __DIR__.'/DB_map.class.php';
class Jiancha_and_jiangduo_gr_score_month_map extends DB_map {
  static $table_name = 'jiancha_and_jiangduo_gr_score_month' ;
  static $police_id = 'jiancha_and_jiangduo_gr_score_month.police_id' ;
  static $police_name = 'jiancha_and_jiangduo_gr_score_month.police_name' ;
  static $dd_name = 'jiancha_and_jiangduo_gr_score_month.dd_name' ;
  static $zhd_name = 'jiancha_and_jiangduo_gr_score_month.zhd_name' ;
  static $year_month_show = 'jiancha_and_jiangduo_gr_score_month.year_month_show' ;
  static $JCDWS_SCORE = 'jiancha_and_jiangduo_gr_score_month.JCDWS_SCORE' ;
  static $FXHZYHWFXWS_SCORE = 'jiancha_and_jiangduo_gr_score_month.FXHZYHWFXWS_SCORE' ;
  static $DCZGHZYHS_SCORE = 'jiancha_and_jiangduo_gr_score_month.DCZGHZYHS_SCORE' ;
  static $XFLSCFJDSS_SCORE = 'jiancha_and_jiangduo_gr_score_month.XFLSCFJDSS_SCORE' ;
  static $jcjd_zdf = 'jiancha_and_jiangduo_gr_score_month.jcjd_zdf' ;
  static $Rank = 'jiancha_and_jiangduo_gr_score_month.Rank' ;
  static $Total_staff_nbr = 'jiancha_and_jiangduo_gr_score_month.Total_staff_nbr' ;
  static $number_id = 'jiancha_and_jiangduo_gr_score_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
