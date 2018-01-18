<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_hzdc_gr_basic_score_month_map extends DB_map {
  static $table_name = 'quantity_hzdc_gr_basic_score_month' ;
  static $police_id = 'quantity_hzdc_gr_basic_score_month.police_id' ;
  static $police_name = 'quantity_hzdc_gr_basic_score_month.police_name' ;
  static $dadui_name = 'quantity_hzdc_gr_basic_score_month.dadui_name' ;
  static $zhidui_name = 'quantity_hzdc_gr_basic_score_month.zhidui_name' ;
  static $year_month_show = 'quantity_hzdc_gr_basic_score_month.year_month_show' ;
  static $zzhzyydc_ybdc_zhubr_score = 'quantity_hzdc_gr_basic_score_month.zzhzyydc_ybdc_zhubr_score' ;
  static $zzhzyydc_ybdc_xiebr_score = 'quantity_hzdc_gr_basic_score_month.zzhzyydc_ybdc_xiebr_score' ;
  static $zzhzyydc_jydc_zhubr_score = 'quantity_hzdc_gr_basic_score_month.zzhzyydc_jydc_zhubr_score' ;
  static $zzhzyydc_jydc_xiebr_score = 'quantity_hzdc_gr_basic_score_month.zzhzyydc_jydc_xiebr_score' ;
  static $number_id = 'quantity_hzdc_gr_basic_score_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
