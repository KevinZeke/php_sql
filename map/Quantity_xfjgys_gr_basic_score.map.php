<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfjgys_gr_basic_score_map extends DB_map {
  static $table_name = 'quantity_xfjgys_gr_basic_score' ;
  static $police_name = 'quantity_xfjgys_gr_basic_score.police_name' ;
  static $dadui_name = 'quantity_xfjgys_gr_basic_score.dadui_name' ;
  static $zhidui_name = 'quantity_xfjgys_gr_basic_score.zhidui_name' ;
  static $year_month_show = 'quantity_xfjgys_gr_basic_score.year_month_show' ;
  static $jsysbahg_zddw_zhubr_score = 'quantity_xfjgys_gr_basic_score.jsysbahg_zddw_zhubr_score' ;
  static $jsysbahg_zddw_xiebr_score = 'quantity_xfjgys_gr_basic_score.jsysbahg_zddw_xiebr_score' ;
  static $jsysbahg_qtdw_zhubr_score = 'quantity_xfjgys_gr_basic_score.jsysbahg_qtdw_zhubr_score' ;
  static $jsysbahg_qtdw_xiebr_score = 'quantity_xfjgys_gr_basic_score.jsysbahg_qtdw_xiebr_score' ;
  static $jsysbabuhg_zddw_zhubr_score = 'quantity_xfjgys_gr_basic_score.jsysbabuhg_zddw_zhubr_score' ;
  static $jsysbabuhg_zddw_xiebr_score = 'quantity_xfjgys_gr_basic_score.jsysbabuhg_zddw_xiebr_score' ;
  static $jsysbabuhg_qtdw_zhubr_score = 'quantity_xfjgys_gr_basic_score.jsysbabuhg_qtdw_zhubr_score' ;
  static $jsysbabuhg_qtdw_xiebr_score = 'quantity_xfjgys_gr_basic_score.jsysbabuhg_qtdw_xiebr_score' ;
  static $police_id = 'quantity_xfjgys_gr_basic_score.police_id' ;
  static $number_id = 'quantity_xfjgys_gr_basic_score.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
