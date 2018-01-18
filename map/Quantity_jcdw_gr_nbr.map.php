<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_jcdw_gr_nbr_map extends DB_map {
  static $table_name = 'quantity_jcdw_gr_nbr' ;
  static $police_id = 'quantity_jcdw_gr_nbr.police_id' ;
  static $police_name = 'quantity_jcdw_gr_nbr.police_name' ;
  static $dd_name = 'quantity_jcdw_gr_nbr.dd_name' ;
  static $zhd_name = 'quantity_jcdw_gr_nbr.zhd_name' ;
  static $year_month_show = 'quantity_jcdw_gr_nbr.year_month_show' ;
  static $rcjdjc_zddw_zhubr = 'quantity_jcdw_gr_nbr.rcjdjc_zddw_zhubr' ;
  static $rcjdjc_zddw_xiebr = 'quantity_jcdw_gr_nbr.rcjdjc_zddw_xiebr' ;
  static $rcjdjc_feizddw_zhubr = 'quantity_jcdw_gr_nbr.rcjdjc_feizddw_zhubr' ;
  static $rcjdjc_feizddw_xiebr = 'quantity_jcdw_gr_nbr.rcjdjc_feizddw_xiebr' ;
  static $yyq_aqjc_zddw_zhubr = 'quantity_jcdw_gr_nbr.yyq_aqjc_zddw_zhubr' ;
  static $yyq_aqjc_zddw_xiebr = 'quantity_jcdw_gr_nbr.yyq_aqjc_zddw_xiebr' ;
  static $yyq_aqjc_feizddw_zhubr = 'quantity_jcdw_gr_nbr.yyq_aqjc_feizddw_zhubr' ;
  static $yyq_aqjc_feizddw_xiebr = 'quantity_jcdw_gr_nbr.yyq_aqjc_feizddw_xiebr' ;
  static $jbq_aqjc_zddw_zhubr = 'quantity_jcdw_gr_nbr.jbq_aqjc_zddw_zhubr' ;
  static $jbq_aqjc_zddw_xiebr = 'quantity_jcdw_gr_nbr.jbq_aqjc_zddw_xiebr' ;
  static $jbq_aqjc_feizddw_zhubr = 'quantity_jcdw_gr_nbr.jbq_aqjc_feizddw_zhubr' ;
  static $jbq_aqjc_feizddw_xiebr = 'quantity_jcdw_gr_nbr.jbq_aqjc_feizddw_xiebr' ;
  static $jbts_jc_zddw_zhubr = 'quantity_jcdw_gr_nbr.jbts_jc_zddw_zhubr' ;
  static $jbts_jc_zddw_xiebr = 'quantity_jcdw_gr_nbr.jbts_jc_zddw_xiebr' ;
  static $jbts_jc_feizddw_zhubr = 'quantity_jcdw_gr_nbr.jbts_jc_feizddw_zhubr' ;
  static $jbts_jc_feizddw_xiebr = 'quantity_jcdw_gr_nbr.jbts_jc_feizddw_xiebr' ;
  static $sggd_jc_zddw_zhubr = 'quantity_jcdw_gr_nbr.sggd_jc_zddw_zhubr' ;
  static $sggd_jc_zddw_xiebr = 'quantity_jcdw_gr_nbr.sggd_jc_zddw_xiebr' ;
  static $sggd_jc_feizddw_zhubr = 'quantity_jcdw_gr_nbr.sggd_jc_feizddw_zhubr' ;
  static $sggd_jc_feizddw_xiebr = 'quantity_jcdw_gr_nbr.sggd_jc_feizddw_xiebr' ;
  static $qt_jc_zddw_zhubr = 'quantity_jcdw_gr_nbr.qt_jc_zddw_zhubr' ;
  static $qt_jc_zddw_xiebr = 'quantity_jcdw_gr_nbr.qt_jc_zddw_xiebr' ;
  static $qt_jc_feizddw_zhubr = 'quantity_jcdw_gr_nbr.qt_jc_feizddw_zhubr' ;
  static $qt_jc_feizddw_xiebr = 'quantity_jcdw_gr_nbr.qt_jc_feizddw_xiebr' ;
  static $fc_jc_zddw_zhubr = 'quantity_jcdw_gr_nbr.fc_jc_zddw_zhubr' ;
  static $fc_jc_zddw_xiebr = 'quantity_jcdw_gr_nbr.fc_jc_zddw_xiebr' ;
  static $fc_jc_feizddw_zhubr = 'quantity_jcdw_gr_nbr.fc_jc_feizddw_zhubr' ;
  static $fc_jc_feizddw_xiebr = 'quantity_jcdw_gr_nbr.fc_jc_feizddw_xiebr' ;
  static $jcdw_tolnum = 'quantity_jcdw_gr_nbr.jcdw_tolnum' ;
  static $number_id = 'quantity_jcdw_gr_nbr.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
