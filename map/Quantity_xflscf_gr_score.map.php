<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xflscf_gr_score_map extends DB_map {
  static $table_name = 'quantity_xflscf_gr_score' ;
  static $police_name = 'quantity_xflscf_gr_score.police_name' ;
  static $dadui_name = 'quantity_xflscf_gr_score.dadui_name' ;
  static $zhidui_name = 'quantity_xflscf_gr_score.zhidui_name' ;
  static $year_month_show = 'quantity_xflscf_gr_score.year_month_show' ;
  static $xflscf_score = 'quantity_xflscf_gr_score.xflscf_score' ;
  static $dadui_rank = 'quantity_xflscf_gr_score.dadui_rank' ;
  static $zhidui_rank = 'quantity_xflscf_gr_score.zhidui_rank' ;
  static $police_id = 'quantity_xflscf_gr_score.police_id' ;
  static $number_id = 'quantity_xflscf_gr_score.number_id' ;
  static function all(){
            //return parent::all();
        }
}
