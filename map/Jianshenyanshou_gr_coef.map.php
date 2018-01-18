<?php 
require_once __DIR__.'/DB_map.class.php';
class Jianshenyanshou_gr_coef_map extends DB_map {
  static $table_name = 'jianshenyanshou_gr_coef' ;
  static $sjshs_coef = 'jianshenyanshou_gr_coef.sjshs_coef' ;
  static $xfyss_coef = 'jianshenyanshou_gr_coef.xfyss_coef' ;
  static $sjbas_coef = 'jianshenyanshou_gr_coef.sjbas_coef' ;
  static $jgysbas_coef = 'jianshenyanshou_gr_coef.jgysbas_coef' ;
  static $number_id = 'jianshenyanshou_gr_coef.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
