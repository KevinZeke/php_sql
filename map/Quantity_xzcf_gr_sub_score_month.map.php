<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xzcf_gr_sub_score_month_map extends DB_map {
  static $table_name = 'quantity_xzcf_gr_sub_score_month' ;
  static $police_id = 'quantity_xzcf_gr_sub_score_month.police_id' ;
  static $police_name = 'quantity_xzcf_gr_sub_score_month.police_name' ;
  static $dd_name = 'quantity_xzcf_gr_sub_score_month.dd_name' ;
  static $zhd_name = 'quantity_xzcf_gr_sub_score_month.zhd_name' ;
  static $year_month_show = 'quantity_xzcf_gr_sub_score_month.year_month_show' ;
  static $zlstdws_sub_score = 'quantity_xzcf_gr_sub_score_month.zlstdws_sub_score' ;
  static $fks_sub_score = 'quantity_xzcf_gr_sub_score_month.fks_sub_score' ;
  static $jls_sub_score = 'quantity_xzcf_gr_sub_score_month.jls_sub_score' ;
  static $xzcf_zdf = 'quantity_xzcf_gr_sub_score_month.xzcf_zdf' ;
  static $dadui_rank = 'quantity_xzcf_gr_sub_score_month.dadui_rank' ;
  static $zhidui_rank = 'quantity_xzcf_gr_sub_score_month.zhidui_rank' ;
  static $number_id = 'quantity_xzcf_gr_sub_score_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
