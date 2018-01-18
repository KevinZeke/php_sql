<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_fxhzyh_gr_score_month_map extends DB_map {
  static $table_name = 'quantity_fxhzyh_gr_score_month' ;
  static $police_name = 'quantity_fxhzyh_gr_score_month.police_name' ;
  static $dadui_name = 'quantity_fxhzyh_gr_score_month.dadui_name' ;
  static $zhidui_name = 'quantity_fxhzyh_gr_score_month.zhidui_name' ;
  static $year_month_show = 'quantity_fxhzyh_gr_score_month.year_month_show' ;
  static $fxhzyh_score = 'quantity_fxhzyh_gr_score_month.fxhzyh_score' ;
  static $dadui_rank = 'quantity_fxhzyh_gr_score_month.dadui_rank' ;
  static $zhidui_rank = 'quantity_fxhzyh_gr_score_month.zhidui_rank' ;
  static $police_id = 'quantity_fxhzyh_gr_score_month.police_id' ;
  static $number_id = 'quantity_fxhzyh_gr_score_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
