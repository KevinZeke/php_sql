<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_xmxx_shys_map extends DB_map {
  static $table_name = 'gzpc_xmxx_shys' ;
  static $id = 'gzpc_xmxx_shys.id' ;
  static $projectId = 'gzpc_xmxx_shys.projectId' ;
  static $projectName = 'gzpc_xmxx_shys.projectName' ;
  static $unitName = 'gzpc_xmxx_shys.unitName' ;
  static $director = 'gzpc_xmxx_shys.director' ;
  static $status = 'gzpc_xmxx_shys.status' ;
  static $createTime = 'gzpc_xmxx_shys.createTime' ;
  static $overTime = 'gzpc_xmxx_shys.overTime' ;
  static $recordTime = 'gzpc_xmxx_shys.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
