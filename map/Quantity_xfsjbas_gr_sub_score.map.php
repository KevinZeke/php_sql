<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfsjbas_gr_sub_score_map extends DB_map {
  static $table_name = 'quantity_xfsjbas_gr_sub_score' ;
  static $police_name = 'quantity_xfsjbas_gr_sub_score.police_name' ;
  static $dadui_name = 'quantity_xfsjbas_gr_sub_score.dadui_name' ;
  static $zhidui_name = 'quantity_xfsjbas_gr_sub_score.zhidui_name' ;
  static $year_month_show = 'quantity_xfsjbas_gr_sub_score.year_month_show' ;
  static $sjbacchg_sub_score = 'quantity_xfsjbas_gr_sub_score.sjbacchg_sub_score' ;
  static $sjbaccbuhg_sub_score = 'quantity_xfsjbas_gr_sub_score.sjbaccbuhg_sub_score' ;
  static $sjbabacc_total_score = 'quantity_xfsjbas_gr_sub_score.sjbabacc_total_score' ;
  static $police_id = 'quantity_xfsjbas_gr_sub_score.police_id' ;
  static $number_id = 'quantity_xfsjbas_gr_sub_score.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
