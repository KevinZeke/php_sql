<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_xmxx_aqjc_map extends DB_map {
  static $table_name = 'gzpc_xmxx_aqjc' ;
  static $id = 'gzpc_xmxx_aqjc.id' ;
  static $projectId = 'gzpc_xmxx_aqjc.projectId' ;
  static $unitName = 'gzpc_xmxx_aqjc.unitName' ;
  static $timeLimit = 'gzpc_xmxx_aqjc.timeLimit' ;
  static $director = 'gzpc_xmxx_aqjc.director' ;
  static $status = 'gzpc_xmxx_aqjc.status' ;
  static $createTime = 'gzpc_xmxx_aqjc.createTime' ;
  static $overTime = 'gzpc_xmxx_aqjc.overTime' ;
  static $recordTime = 'gzpc_xmxx_aqjc.recordTime' ;
  static function all(){
            //return parent::all();
        }
}
