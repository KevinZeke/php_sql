<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfyss_gr_nbr_month_map extends DB_map {
  static $table_name = 'quantity_xfyss_gr_nbr_month' ;
  static $police_name = 'quantity_xfyss_gr_nbr_month.police_name' ;
  static $dadui_name = 'quantity_xfyss_gr_nbr_month.dadui_name' ;
  static $zhidui_name = 'quantity_xfyss_gr_nbr_month.zhidui_name' ;
  static $year_month_show = 'quantity_xfyss_gr_nbr_month.year_month_show' ;
  static $gcyshg_zddw_zhubr = 'quantity_xfyss_gr_nbr_month.gcyshg_zddw_zhubr' ;
  static $gcyshg_zddw_xiebr = 'quantity_xfyss_gr_nbr_month.gcyshg_zddw_xiebr' ;
  static $gcyshg_qtdw_zhubr = 'quantity_xfyss_gr_nbr_month.gcyshg_qtdw_zhubr' ;
  static $gcyshg_qtdw_xiebr = 'quantity_xfyss_gr_nbr_month.gcyshg_qtdw_xiebr' ;
  static $gcysbuhg_zddw_zhubr = 'quantity_xfyss_gr_nbr_month.gcysbuhg_zddw_zhubr' ;
  static $gcysbuhg_zddw_xiebr = 'quantity_xfyss_gr_nbr_month.gcysbuhg_zddw_xiebr' ;
  static $gcysbuhg_qtdw_zhubr = 'quantity_xfyss_gr_nbr_month.gcysbuhg_qtdw_zhubr' ;
  static $gcysbuhg_qtdw_xiebr = 'quantity_xfyss_gr_nbr_month.gcysbuhg_qtdw_xiebr' ;
  static $police_id = 'quantity_xfyss_gr_nbr_month.police_id' ;
  static $number_id = 'quantity_xfyss_gr_nbr_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
