<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_flws_xzcf_map extends DB_map {
  static $table_name = 'gzpc_flws_xzcf' ;
  static $id = 'gzpc_flws_xzcf.id' ;
  static $taskId = 'gzpc_flws_xzcf.taskId' ;
  static $itemId = 'gzpc_flws_xzcf.itemId' ;
  static $nodeName = 'gzpc_flws_xzcf.nodeName' ;
  static $name = 'gzpc_flws_xzcf.name' ;
  static $isFile = 'gzpc_flws_xzcf.isFile' ;
  static $creatorPerson = 'gzpc_flws_xzcf.creatorPerson' ;
  static $createTime = 'gzpc_flws_xzcf.createTime' ;
  static $checkPerson = 'gzpc_flws_xzcf.checkPerson' ;
  static $checkTime = 'gzpc_flws_xzcf.checkTime' ;
  static $firstCheckTime = 'gzpc_flws_xzcf.firstCheckTime' ;
  static $status = 'gzpc_flws_xzcf.status' ;
  static $recordTime = 'gzpc_flws_xzcf.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
