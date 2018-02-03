<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_gr_score_map extends DB_map {
  static $table_name = 'quantity_gr_score' ;
  static $jdjc_zdf_weighed = 'quantity_gr_score.jdjc_zdf_weighed' ;
  static $xzcf_zdf_weighed = 'quantity_gr_score.xzcf_zdf_weighed' ;
  static $hzdc_zdf_weighed = 'quantity_gr_score.hzdc_zdf_weighed' ;
  static $jsys_zdf_weighed = 'quantity_gr_score.jsys_zdf_weighed' ;
  static $zfsl_total_score = 'quantity_gr_score.zfsl_total_score' ;
  static $zhidui_rank = 'quantity_gr_score.zhidui_rank' ;
  static $total_zhidui_staff_nbr = 'quantity_gr_score.total_zhidui_staff_nbr' ;
  static $number_id = 'quantity_gr_score.number_id' ;
  static $police_name = 'quantity_gr_score.police_name' ;
  static $year_month_show = 'quantity_gr_score.year_month_show' ;
  static $dd_name = 'quantity_gr_score.dd_name' ;
  static $zhd_name = 'quantity_gr_score.zhd_name' ;
  static function all(){
            //return parent::all();
        }
}
