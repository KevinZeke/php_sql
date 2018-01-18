<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_dczghzyhwf_gr_score_map extends DB_map {
  static $table_name = 'quantity_dczghzyhwf_gr_score' ;
  static $police_name = 'quantity_dczghzyhwf_gr_score.police_name' ;
  static $dadui_name = 'quantity_dczghzyhwf_gr_score.dadui_name' ;
  static $zhidui_name = 'quantity_dczghzyhwf_gr_score.zhidui_name' ;
  static $year_month_show = 'quantity_dczghzyhwf_gr_score.year_month_show' ;
  static $dczghzyhwf_score = 'quantity_dczghzyhwf_gr_score.dczghzyhwf_score' ;
  static $dadui_rank = 'quantity_dczghzyhwf_gr_score.dadui_rank' ;
  static $zhidui_rank = 'quantity_dczghzyhwf_gr_score.zhidui_rank' ;
  static $police_id = 'quantity_dczghzyhwf_gr_score.police_id' ;
  static $number_id = 'quantity_dczghzyhwf_gr_score.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
