<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_flws_aqjc_map extends DB_map {
  static $table_name = 'gzpc_flws_aqjc' ;
  static $id = 'gzpc_flws_aqjc.id' ;
  static $projectId = 'gzpc_flws_aqjc.projectId' ;
  static $itemId = 'gzpc_flws_aqjc.itemId' ;
  static $name = 'gzpc_flws_aqjc.name' ;
  static $isFile = 'gzpc_flws_aqjc.isFile' ;
  static $creatorPerson = 'gzpc_flws_aqjc.creatorPerson' ;
  static $createTime = 'gzpc_flws_aqjc.createTime' ;
  static $checkPerson = 'gzpc_flws_aqjc.checkPerson' ;
  static $checkTime = 'gzpc_flws_aqjc.checkTime' ;
  static $status = 'gzpc_flws_aqjc.status' ;
  static $recordTime = 'gzpc_flws_aqjc.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
