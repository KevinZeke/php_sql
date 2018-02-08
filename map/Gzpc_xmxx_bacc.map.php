<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_xmxx_bacc_map extends DB_map {
  static $table_name = 'gzpc_xmxx_bacc' ;
  static $id = 'gzpc_xmxx_bacc.id' ;
  static $projectId = 'gzpc_xmxx_bacc.projectId' ;
  static $projectName = 'gzpc_xmxx_bacc.projectName' ;
  static $unitName = 'gzpc_xmxx_bacc.unitName' ;
  static $result = 'gzpc_xmxx_bacc.result' ;
  static $director = 'gzpc_xmxx_bacc.director' ;
  static $status = 'gzpc_xmxx_bacc.status' ;
  static $createTime = 'gzpc_xmxx_bacc.createTime' ;
  static $overTime = 'gzpc_xmxx_bacc.overTime' ;
  static $recordTime = 'gzpc_xmxx_bacc.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
