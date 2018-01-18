<?php 
require_once __DIR__.'/DB_map.class.php';
class Jiancha_and_jiangduo_gr_nbr_month_map extends DB_map {
  static $table_name = 'jiancha_and_jiangduo_gr_nbr_month' ;
  static $police_id = 'jiancha_and_jiangduo_gr_nbr_month.police_id' ;
  static $police_name = 'jiancha_and_jiangduo_gr_nbr_month.police_name' ;
  static $dd_name = 'jiancha_and_jiangduo_gr_nbr_month.dd_name' ;
  static $zhd_name = 'jiancha_and_jiangduo_gr_nbr_month.zhd_name' ;
  static $year_month_show = 'jiancha_and_jiangduo_gr_nbr_month.year_month_show' ;
  static $JCDWS_DF = 'jiancha_and_jiangduo_gr_nbr_month.JCDWS_DF' ;
  static $FXHZYHWFXWS_DF = 'jiancha_and_jiangduo_gr_nbr_month.FXHZYHWFXWS_DF' ;
  static $DCZGHZYHS_DF = 'jiancha_and_jiangduo_gr_nbr_month.DCZGHZYHS_DF' ;
  static $XFLSCFJDSS_DF = 'jiancha_and_jiangduo_gr_nbr_month.XFLSCFJDSS_DF' ;
  static $JCJD_ZDF = 'jiancha_and_jiangduo_gr_nbr_month.JCJD_ZDF' ;
  static $Rank = 'jiancha_and_jiangduo_gr_nbr_month.Rank' ;
  static $Total_staff_nbr = 'jiancha_and_jiangduo_gr_nbr_month.Total_staff_nbr' ;
  static $number_id = 'jiancha_and_jiangduo_gr_nbr_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
