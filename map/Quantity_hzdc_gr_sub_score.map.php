<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_hzdc_gr_sub_score_map extends DB_map {
  static $table_name = 'quantity_hzdc_gr_sub_score' ;
  static $police_name = 'quantity_hzdc_gr_sub_score.police_name' ;
  static $dadui_name = 'quantity_hzdc_gr_sub_score.dadui_name' ;
  static $zhidui_name = 'quantity_hzdc_gr_sub_score.zhidui_name' ;
  static $year_month_show = 'quantity_hzdc_gr_sub_score.year_month_show' ;
  static $hzdcs_sub_score = 'quantity_hzdc_gr_sub_score.hzdcs_sub_score' ;
  static $hzdcs_total_score = 'quantity_hzdc_gr_sub_score.hzdcs_total_score' ;
  static $dadui_rank = 'quantity_hzdc_gr_sub_score.dadui_rank' ;
  static $zhidui_rank = 'quantity_hzdc_gr_sub_score.zhidui_rank' ;
  static $police_id = 'quantity_hzdc_gr_sub_score.police_id' ;
  static $number_id = 'quantity_hzdc_gr_sub_score.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
