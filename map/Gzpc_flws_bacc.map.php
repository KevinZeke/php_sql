<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_flws_bacc_map extends DB_map {
  static $table_name = 'gzpc_flws_bacc' ;
  static $id = 'gzpc_flws_bacc.id' ;
  static $projectId = 'gzpc_flws_bacc.projectId' ;
  static $itemId = 'gzpc_flws_bacc.itemId' ;
  static $name = 'gzpc_flws_bacc.name' ;
  static $isFile = 'gzpc_flws_bacc.isFile' ;
  static $creatorPerson = 'gzpc_flws_bacc.creatorPerson' ;
  static $createTime = 'gzpc_flws_bacc.createTime' ;
  static $checkPerson = 'gzpc_flws_bacc.checkPerson' ;
  static $checkTime = 'gzpc_flws_bacc.checkTime' ;
  static $status = 'gzpc_flws_bacc.status' ;
  static $recordTime = 'gzpc_flws_bacc.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
