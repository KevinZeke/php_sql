<?php 
require_once __DIR__.'/DB_map.class.php';
class Jiancha_and_jiangduo_gr_nbr_map extends DB_map {
  static $table_name = 'jiancha_and_jiangduo_gr_nbr' ;
  static $police_id = 'jiancha_and_jiangduo_gr_nbr.police_id' ;
  static $police_name = 'jiancha_and_jiangduo_gr_nbr.police_name' ;
  static $dd_name = 'jiancha_and_jiangduo_gr_nbr.dd_name' ;
  static $zhd_name = 'jiancha_and_jiangduo_gr_nbr.zhd_name' ;
  static $year_month_show = 'jiancha_and_jiangduo_gr_nbr.year_month_show' ;
  static $JCDWS_DF = 'jiancha_and_jiangduo_gr_nbr.JCDWS_DF' ;
  static $FXHZYHWFXWS_DF = 'jiancha_and_jiangduo_gr_nbr.FXHZYHWFXWS_DF' ;
  static $DCZGHZYHS_DF = 'jiancha_and_jiangduo_gr_nbr.DCZGHZYHS_DF' ;
  static $XFLSCFJDSS_DF = 'jiancha_and_jiangduo_gr_nbr.XFLSCFJDSS_DF' ;
  static $JCJD_ZDF = 'jiancha_and_jiangduo_gr_nbr.JCJD_ZDF' ;
  static $Rank = 'jiancha_and_jiangduo_gr_nbr.Rank' ;
  static $Total_staff_nbr = 'jiancha_and_jiangduo_gr_nbr.Total_staff_nbr' ;
  static $number_id = 'jiancha_and_jiangduo_gr_nbr.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
