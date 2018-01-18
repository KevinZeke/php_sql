<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfsjshs_gr_basic_score_month_map extends DB_map {
  static $table_name = 'quantity_xfsjshs_gr_basic_score_month' ;
  static $police_name = 'quantity_xfsjshs_gr_basic_score_month.police_name' ;
  static $dadui_name = 'quantity_xfsjshs_gr_basic_score_month.dadui_name' ;
  static $zhidui_name = 'quantity_xfsjshs_gr_basic_score_month.zhidui_name' ;
  static $year_month_show = 'quantity_xfsjshs_gr_basic_score_month.year_month_show' ;
  static $sjshhg_zddw_zhubr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshhg_zddw_zhubr_score' ;
  static $sjshhg_zddw_xiebr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshhg_zddw_xiebr_score' ;
  static $sjshhg_qtdw_zhubr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshhg_qtdw_zhubr_score' ;
  static $sjshhg_qtdw_xiebr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshhg_qtdw_xiebr_score' ;
  static $sjshbuhg_zddw_zhubr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshbuhg_zddw_zhubr_score' ;
  static $sjshbuhg_zddw_xiebr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshbuhg_zddw_xiebr_score' ;
  static $sjshbuhg_qtdw_zhubr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshbuhg_qtdw_zhubr_score' ;
  static $sjshbuhg_qtdw_xiebr_score = 'quantity_xfsjshs_gr_basic_score_month.sjshbuhg_qtdw_xiebr_score' ;
  static $police_id = 'quantity_xfsjshs_gr_basic_score_month.police_id' ;
  static $number_id = 'quantity_xfsjshs_gr_basic_score_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
