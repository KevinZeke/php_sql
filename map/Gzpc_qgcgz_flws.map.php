<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_qgcgz_flws_map extends DB_map {
  static $table_name = 'gzpc_qgcgz_flws' ;
  static $id = 'gzpc_qgcgz_flws.id' ;
  static $relatedTable = 'gzpc_qgcgz_flws.relatedTable' ;
  static $relatedId = 'gzpc_qgcgz_flws.relatedId' ;
  static $itemId = 'gzpc_qgcgz_flws.itemId' ;
  static $itemName = 'gzpc_qgcgz_flws.itemName' ;
  static $itemType = 'gzpc_qgcgz_flws.itemType' ;
  static $operator = 'gzpc_qgcgz_flws.operator' ;
  static $action = 'gzpc_qgcgz_flws.action' ;
  static $result = 'gzpc_qgcgz_flws.result' ;
  static $info = 'gzpc_qgcgz_flws.info' ;
  static $createTime = 'gzpc_qgcgz_flws.createTime' ;
  static $recordTime = 'gzpc_qgcgz_flws.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
