<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xzcf_gr_nbr_map extends DB_map {
  static $table_name = 'quantity_xzcf_gr_nbr' ;
  static $police_id = 'quantity_xzcf_gr_nbr.police_id' ;
  static $police_name = 'quantity_xzcf_gr_nbr.police_name' ;
  static $dd_name = 'quantity_xzcf_gr_nbr.dd_name' ;
  static $zhd_name = 'quantity_xzcf_gr_nbr.zhd_name' ;
  static $year_month_show = 'quantity_xzcf_gr_nbr.year_month_show' ;
  static $zlstdws_zddw_zhubr = 'quantity_xzcf_gr_nbr.zlstdws_zddw_zhubr' ;
  static $zlstdws_zddw_xiebr = 'quantity_xzcf_gr_nbr.zlstdws_zddw_xiebr' ;
  static $zlstdws_feizddw_zhubr = 'quantity_xzcf_gr_nbr.zlstdws_feizddw_zhubr' ;
  static $zlstdws_feizddw_xiebr = 'quantity_xzcf_gr_nbr.zlstdws_feizddw_xiebr' ;
  static $zlstdws_sub_total_nbr = 'quantity_xzcf_gr_nbr.zlstdws_sub_total_nbr' ;
  static $fks_zddw_zhubr = 'quantity_xzcf_gr_nbr.fks_zddw_zhubr' ;
  static $fks_zddw_xiebr = 'quantity_xzcf_gr_nbr.fks_zddw_xiebr' ;
  static $fks_feizddw_zhubr = 'quantity_xzcf_gr_nbr.fks_feizddw_zhubr' ;
  static $fks_feizddw_xiebr = 'quantity_xzcf_gr_nbr.fks_feizddw_xiebr' ;
  static $fks_sub_total_nbr = 'quantity_xzcf_gr_nbr.fks_sub_total_nbr' ;
  static $jls_zddw_zhubr = 'quantity_xzcf_gr_nbr.jls_zddw_zhubr' ;
  static $jls_zddw_xiebr = 'quantity_xzcf_gr_nbr.jls_zddw_xiebr' ;
  static $jls_feizddw_zhubr = 'quantity_xzcf_gr_nbr.jls_feizddw_zhubr' ;
  static $jls_feizddw_xiebr = 'quantity_xzcf_gr_nbr.jls_feizddw_xiebr' ;
  static $jls_sub_total_nbr = 'quantity_xzcf_gr_nbr.jls_sub_total_nbr' ;
  static $number_id = 'quantity_xzcf_gr_nbr.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
