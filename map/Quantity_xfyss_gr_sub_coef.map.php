<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfyss_gr_sub_coef_map extends DB_map {
  static $table_name = 'quantity_xfyss_gr_sub_coef' ;
  static $gcyshg_zxqz = 'quantity_xfyss_gr_sub_coef.gcyshg_zxqz' ;
  static $gcysbuhg_zxqz = 'quantity_xfyss_gr_sub_coef.gcysbuhg_zxqz' ;
  static $number_id = 'quantity_xfyss_gr_sub_coef.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
