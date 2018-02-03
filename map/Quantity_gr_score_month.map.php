<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_gr_score_month_map extends DB_map {
  static $table_name = 'quantity_gr_score_month' ;
  static $jdjc_zdf_weighed = 'quantity_gr_score_month.jdjc_zdf_weighed' ;
  static $xzcf_zdf_weighed = 'quantity_gr_score_month.xzcf_zdf_weighed' ;
  static $hzdc_zdf_weighed = 'quantity_gr_score_month.hzdc_zdf_weighed' ;
  static $jsys_zdf_weighed = 'quantity_gr_score_month.jsys_zdf_weighed' ;
  static $zfsl_total_score = 'quantity_gr_score_month.zfsl_total_score' ;
  static $zhidui_rank = 'quantity_gr_score_month.zhidui_rank' ;
  static $total_zhidui_staff_nbr = 'quantity_gr_score_month.total_zhidui_staff_nbr' ;
  static $number_id = 'quantity_gr_score_month.number_id' ;
  static $police_name = 'quantity_gr_score_month.police_name' ;
  static $year_month_show = 'quantity_gr_score_month.year_month_show' ;
  static $dd_name = 'quantity_gr_score_month.dd_name' ;
  static $zhd_name = 'quantity_gr_score_month.zhd_name' ;
  static function all(){
            //return parent::all();
        }
}
