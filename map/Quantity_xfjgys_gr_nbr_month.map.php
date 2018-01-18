<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfjgys_gr_nbr_month_map extends DB_map {
  static $table_name = 'quantity_xfjgys_gr_nbr_month' ;
  static $police_name = 'quantity_xfjgys_gr_nbr_month.police_name' ;
  static $dadui_name = 'quantity_xfjgys_gr_nbr_month.dadui_name' ;
  static $zhidui_name = 'quantity_xfjgys_gr_nbr_month.zhidui_name' ;
  static $year_month_show = 'quantity_xfjgys_gr_nbr_month.year_month_show' ;
  static $jsysbahg_zddw_zhubr = 'quantity_xfjgys_gr_nbr_month.jsysbahg_zddw_zhubr' ;
  static $jsysbahg_zddw_xiebr = 'quantity_xfjgys_gr_nbr_month.jsysbahg_zddw_xiebr' ;
  static $jsysbahg_qtdw_zhubr = 'quantity_xfjgys_gr_nbr_month.jsysbahg_qtdw_zhubr' ;
  static $jsysbahg_qtdw_xiebr = 'quantity_xfjgys_gr_nbr_month.jsysbahg_qtdw_xiebr' ;
  static $jsysbabuhg_zddw_zhubr = 'quantity_xfjgys_gr_nbr_month.jsysbabuhg_zddw_zhubr' ;
  static $jsysbabuhg_zddw_xiebr = 'quantity_xfjgys_gr_nbr_month.jsysbabuhg_zddw_xiebr' ;
  static $jsysbabuhg_qtdw_zhubr = 'quantity_xfjgys_gr_nbr_month.jsysbabuhg_qtdw_zhubr' ;
  static $jsysbabuhg_qtdw_xiebr = 'quantity_xfjgys_gr_nbr_month.jsysbabuhg_qtdw_xiebr' ;
  static $police_id = 'quantity_xfjgys_gr_nbr_month.police_id' ;
  static $number_id = 'quantity_xfjgys_gr_nbr_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
