<?php 
require_once __DIR__.'/DB_map.class.php';
class Xm_pingyoutongbao_map extends DB_map {
  static $table_name = 'xm_pingyoutongbao' ;
  static $xmbh = 'xm_pingyoutongbao.xmbh' ;
  static $xmlx = 'xm_pingyoutongbao.xmlx' ;
  static $action = 'xm_pingyoutongbao.action' ;
  static $SetTime = 'xm_pingyoutongbao.SetTime' ;
  static $id = 'xm_pingyoutongbao.id' ;
  static function all(){
            //return parent::all();
        }
}
