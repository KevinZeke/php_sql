<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_flws_shys_map extends DB_map {
  static $table_name = 'gzpc_flws_shys' ;
  static $id = 'gzpc_flws_shys.id' ;
  static $projectId = 'gzpc_flws_shys.projectId' ;
  static $itemId = 'gzpc_flws_shys.itemId' ;
  static $name = 'gzpc_flws_shys.name' ;
  static $isFile = 'gzpc_flws_shys.isFile' ;
  static $creatorPerson = 'gzpc_flws_shys.creatorPerson' ;
  static $createTime = 'gzpc_flws_shys.createTime' ;
  static $checkPerson = 'gzpc_flws_shys.checkPerson' ;
  static $checkTime = 'gzpc_flws_shys.checkTime' ;
  static $status = 'gzpc_flws_shys.status' ;
  static $recordTime = 'gzpc_flws_shys.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
