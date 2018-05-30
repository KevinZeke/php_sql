<?php 
require_once __DIR__.'/DB_map.class.php';
class Kpdf_huizong_map extends DB_map {
  static $table_name = 'kpdf_huizong' ;
  static $Item_BH = 'kpdf_huizong.Item_BH' ;
  static $Item_Type = 'kpdf_huizong.Item_Type' ;
  static $flwsID = 'kpdf_huizong.flwsID' ;
  static $kplb = 'kpdf_huizong.kplb' ;
  static $kp_name = 'kpdf_huizong.kp_name' ;
  static $result = 'kpdf_huizong.result' ;
  static $num_id = 'kpdf_huizong.num_id' ;
  static $kptime = 'kpdf_huizong.kptime' ;
  static $remark = 'kpdf_huizong.remark' ;
  static function all(){
            //return parent::all();
        }
}
