<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xflscf_gr_nbr_month_map extends DB_map {
  static $table_name = 'quantity_xflscf_gr_nbr_month' ;
  static $police_name = 'quantity_xflscf_gr_nbr_month.police_name' ;
  static $dadui_name = 'quantity_xflscf_gr_nbr_month.dadui_name' ;
  static $zhidui_name = 'quantity_xflscf_gr_nbr_month.zhidui_name' ;
  static $year_month_show = 'quantity_xflscf_gr_nbr_month.year_month_show' ;
  static $xflscf_zddw_zhubr = 'quantity_xflscf_gr_nbr_month.xflscf_zddw_zhubr' ;
  static $xflscf_zddw_xiebr = 'quantity_xflscf_gr_nbr_month.xflscf_zddw_xiebr' ;
  static $xflscf_feizddw_zhubr = 'quantity_xflscf_gr_nbr_month.xflscf_feizddw_zhubr' ;
  static $xflscf_feizddw_xiebr = 'quantity_xflscf_gr_nbr_month.xflscf_feizddw_xiebr' ;
  static $police_id = 'quantity_xflscf_gr_nbr_month.police_id' ;
  static $number_id = 'quantity_xflscf_gr_nbr_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
