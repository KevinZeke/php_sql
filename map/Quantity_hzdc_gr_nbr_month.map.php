<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_hzdc_gr_nbr_month_map extends DB_map {
  static $table_name = 'quantity_hzdc_gr_nbr_month' ;
  static $police_name = 'quantity_hzdc_gr_nbr_month.police_name' ;
  static $dadui_name = 'quantity_hzdc_gr_nbr_month.dadui_name' ;
  static $zhidui_name = 'quantity_hzdc_gr_nbr_month.zhidui_name' ;
  static $year_month_show = 'quantity_hzdc_gr_nbr_month.year_month_show' ;
  static $zzhzyydc_ybdc_zhubr = 'quantity_hzdc_gr_nbr_month.zzhzyydc_ybdc_zhubr' ;
  static $zzhzyydc_ybdc_xiebr = 'quantity_hzdc_gr_nbr_month.zzhzyydc_ybdc_xiebr' ;
  static $zzhzyydc_jydc_zhubr = 'quantity_hzdc_gr_nbr_month.zzhzyydc_jydc_zhubr' ;
  static $zzhzyydc_jydc_xiebr = 'quantity_hzdc_gr_nbr_month.zzhzyydc_jydc_xiebr' ;
  static $police_id = 'quantity_hzdc_gr_nbr_month.police_id' ;
  static $number_id = 'quantity_hzdc_gr_nbr_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
