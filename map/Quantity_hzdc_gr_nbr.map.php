<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_hzdc_gr_nbr_map extends DB_map {
  static $table_name = 'quantity_hzdc_gr_nbr' ;
  static $police_name = 'quantity_hzdc_gr_nbr.police_name' ;
  static $dadui_name = 'quantity_hzdc_gr_nbr.dadui_name' ;
  static $zhidui_name = 'quantity_hzdc_gr_nbr.zhidui_name' ;
  static $year_month_show = 'quantity_hzdc_gr_nbr.year_month_show' ;
  static $zzhzyydc_ybdc_zhubr = 'quantity_hzdc_gr_nbr.zzhzyydc_ybdc_zhubr' ;
  static $zzhzyydc_ybdc_xiebr = 'quantity_hzdc_gr_nbr.zzhzyydc_ybdc_xiebr' ;
  static $zzhzyydc_jydc_zhubr = 'quantity_hzdc_gr_nbr.zzhzyydc_jydc_zhubr' ;
  static $zzhzyydc_jydc_xiebr = 'quantity_hzdc_gr_nbr.zzhzyydc_jydc_xiebr' ;
  static $police_id = 'quantity_hzdc_gr_nbr.police_id' ;
  static $number_id = 'quantity_hzdc_gr_nbr.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
