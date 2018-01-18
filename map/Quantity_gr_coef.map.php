<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_gr_coef_map extends DB_map {
  static $table_name = 'quantity_gr_coef' ;
  static $jdjc_coef = 'quantity_gr_coef.jdjc_coef' ;
  static $xzcf_coef = 'quantity_gr_coef.xzcf_coef' ;
  static $hzdc_coef = 'quantity_gr_coef.hzdc_coef' ;
  static $jsys_coef = 'quantity_gr_coef.jsys_coef' ;
  static $number_id = 'quantity_gr_coef.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
