<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xzcf_gr_sub_coef_map extends DB_map {
  static $table_name = 'quantity_xzcf_gr_sub_coef' ;
  static $zlstdws_zxqz = 'quantity_xzcf_gr_sub_coef.zlstdws_zxqz' ;
  static $fks_zxqz = 'quantity_xzcf_gr_sub_coef.fks_zxqz' ;
  static $jls_zxqz = 'quantity_xzcf_gr_sub_coef.jls_zxqz' ;
  static $number_id = 'quantity_xzcf_gr_sub_coef.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
