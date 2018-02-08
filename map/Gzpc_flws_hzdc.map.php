<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_flws_hzdc_map extends DB_map {
  static $table_name = 'gzpc_flws_hzdc' ;
  static $id = 'gzpc_flws_hzdc.id' ;
  static $taskId = 'gzpc_flws_hzdc.taskId' ;
  static $itemId = 'gzpc_flws_hzdc.itemId' ;
  static $nodeName = 'gzpc_flws_hzdc.nodeName' ;
  static $name = 'gzpc_flws_hzdc.name' ;
  static $isFile = 'gzpc_flws_hzdc.isFile' ;
  static $creatorPerson = 'gzpc_flws_hzdc.creatorPerson' ;
  static $createTime = 'gzpc_flws_hzdc.createTime' ;
  static $checkPerson = 'gzpc_flws_hzdc.checkPerson' ;
  static $checkTime = 'gzpc_flws_hzdc.checkTime' ;
  static $status = 'gzpc_flws_hzdc.status' ;
  static $recordTime = 'gzpc_flws_hzdc.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
