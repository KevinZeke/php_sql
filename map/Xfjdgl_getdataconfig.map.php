<?php 
require_once __DIR__.'/DB_map.class.php';
class Xfjdgl_getdataconfig_map extends DB_map {
  static $table_name = 'xfjdgl_getdataconfig' ;
  static $number_id = 'xfjdgl_getdataconfig.number_id' ;
  static $startdate_Y_M_D = 'xfjdgl_getdataconfig.startdate_Y_M_D' ;
  static $startdate_Y_M_D_month = 'xfjdgl_getdataconfig.startdate_Y_M_D_month' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
