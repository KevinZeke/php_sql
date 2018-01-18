<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_jcdw_gr_score_month_map extends DB_map {
  static $table_name = 'quantity_jcdw_gr_score_month' ;
  static $police_id = 'quantity_jcdw_gr_score_month.police_id' ;
  static $police_name = 'quantity_jcdw_gr_score_month.police_name' ;
  static $dd_name = 'quantity_jcdw_gr_score_month.dd_name' ;
  static $zhd_name = 'quantity_jcdw_gr_score_month.zhd_name' ;
  static $year_month_show = 'quantity_jcdw_gr_score_month.year_month_show' ;
  static $rcjdjc_xxdf = 'quantity_jcdw_gr_score_month.rcjdjc_xxdf' ;
  static $rcjdjc_zxdf = 'quantity_jcdw_gr_score_month.rcjdjc_zxdf' ;
  static $yyq_aqjc_xxdf = 'quantity_jcdw_gr_score_month.yyq_aqjc_xxdf' ;
  static $yyq_aqjc_zxdf = 'quantity_jcdw_gr_score_month.yyq_aqjc_zxdf' ;
  static $jbq_aqjc_xxdf = 'quantity_jcdw_gr_score_month.jbq_aqjc_xxdf' ;
  static $jbq_aqjc_zxdf = 'quantity_jcdw_gr_score_month.jbq_aqjc_zxdf' ;
  static $jbts_jc_xxdf = 'quantity_jcdw_gr_score_month.jbts_jc_xxdf' ;
  static $jbts_jc_zxdf = 'quantity_jcdw_gr_score_month.jbts_jc_zxdf' ;
  static $sggd_jc_xxdf = 'quantity_jcdw_gr_score_month.sggd_jc_xxdf' ;
  static $sggd_jc_zxdf = 'quantity_jcdw_gr_score_month.sggd_jc_zxdf' ;
  static $qt_jc_xxdf = 'quantity_jcdw_gr_score_month.qt_jc_xxdf' ;
  static $qt_jc_zxdf = 'quantity_jcdw_gr_score_month.qt_jc_zxdf' ;
  static $fc_jc_xxdf = 'quantity_jcdw_gr_score_month.fc_jc_xxdf' ;
  static $fc_jc_zxdf = 'quantity_jcdw_gr_score_month.fc_jc_zxdf' ;
  static $jcdw_tol_score = 'quantity_jcdw_gr_score_month.jcdw_tol_score' ;
  static $dadui_rank = 'quantity_jcdw_gr_score_month.dadui_rank' ;
  static $zhidui_rank = 'quantity_jcdw_gr_score_month.zhidui_rank' ;
  static $number_id = 'quantity_jcdw_gr_score_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
