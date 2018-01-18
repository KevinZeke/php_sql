<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_jcdw_gr_score_map extends DB_map {
  static $table_name = 'quantity_jcdw_gr_score' ;
  static $police_id = 'quantity_jcdw_gr_score.police_id' ;
  static $police_name = 'quantity_jcdw_gr_score.police_name' ;
  static $dd_name = 'quantity_jcdw_gr_score.dd_name' ;
  static $zhd_name = 'quantity_jcdw_gr_score.zhd_name' ;
  static $year_month_show = 'quantity_jcdw_gr_score.year_month_show' ;
  static $rcjdjc_xxdf = 'quantity_jcdw_gr_score.rcjdjc_xxdf' ;
  static $rcjdjc_zxdf = 'quantity_jcdw_gr_score.rcjdjc_zxdf' ;
  static $yyq_aqjc_xxdf = 'quantity_jcdw_gr_score.yyq_aqjc_xxdf' ;
  static $yyq_aqjc_zxdf = 'quantity_jcdw_gr_score.yyq_aqjc_zxdf' ;
  static $jbq_aqjc_xxdf = 'quantity_jcdw_gr_score.jbq_aqjc_xxdf' ;
  static $jbq_aqjc_zxdf = 'quantity_jcdw_gr_score.jbq_aqjc_zxdf' ;
  static $jbts_jc_xxdf = 'quantity_jcdw_gr_score.jbts_jc_xxdf' ;
  static $jbts_jc_zxdf = 'quantity_jcdw_gr_score.jbts_jc_zxdf' ;
  static $sggd_jc_xxdf = 'quantity_jcdw_gr_score.sggd_jc_xxdf' ;
  static $sggd_jc_zxdf = 'quantity_jcdw_gr_score.sggd_jc_zxdf' ;
  static $qt_jc_xxdf = 'quantity_jcdw_gr_score.qt_jc_xxdf' ;
  static $qt_jc_zxdf = 'quantity_jcdw_gr_score.qt_jc_zxdf' ;
  static $fc_jc_xxdf = 'quantity_jcdw_gr_score.fc_jc_xxdf' ;
  static $fc_jc_zxdf = 'quantity_jcdw_gr_score.fc_jc_zxdf' ;
  static $jcdw_tol_score = 'quantity_jcdw_gr_score.jcdw_tol_score' ;
  static $dadui_rank = 'quantity_jcdw_gr_score.dadui_rank' ;
  static $zhidui_rank = 'quantity_jcdw_gr_score.zhidui_rank' ;
  static $number_id = 'quantity_jcdw_gr_score.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
