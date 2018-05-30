<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_xmxx_xzcf_map extends DB_map {
  static $table_name = 'gzpc_xmxx_xzcf' ;
  static $id = 'gzpc_xmxx_xzcf.id' ;
  static $taskId = 'gzpc_xmxx_xzcf.taskId' ;
  static $unitName = 'gzpc_xmxx_xzcf.unitName' ;
  static $reason = 'gzpc_xmxx_xzcf.reason' ;
  static $director = 'gzpc_xmxx_xzcf.director' ;
  static $timeLimit = 'gzpc_xmxx_xzcf.timeLimit' ;
  static $status = 'gzpc_xmxx_xzcf.status' ;
  static $createTime = 'gzpc_xmxx_xzcf.createTime' ;
  static $cjTime = 'gzpc_xmxx_xzcf.cjTime' ;
  static $overTime = 'gzpc_xmxx_xzcf.overTime' ;
  static $updateTime = 'gzpc_xmxx_xzcf.updateTime' ;
  static $recordTime = 'gzpc_xmxx_xzcf.recordTime' ;
  static $ContactNum = 'gzpc_xmxx_xzcf.ContactNum' ;
  static function all(){
            //return parent::all();
        }
}
