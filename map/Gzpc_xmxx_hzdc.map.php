<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_xmxx_hzdc_map extends DB_map {
  static $table_name = 'gzpc_xmxx_hzdc' ;
  static $id = 'gzpc_xmxx_hzdc.id' ;
  static $taskId = 'gzpc_xmxx_hzdc.taskId' ;
  static $HzdcType = 'gzpc_xmxx_hzdc.HzdcType' ;
  static $FirePart = 'gzpc_xmxx_hzdc.FirePart' ;
  static $FireAddress = 'gzpc_xmxx_hzdc.FireAddress' ;
  static $Director = 'gzpc_xmxx_hzdc.Director' ;
  static $FireTime = 'gzpc_xmxx_hzdc.FireTime' ;
  static $EndDate = 'gzpc_xmxx_hzdc.EndDate' ;
  static $HandleDate = 'gzpc_xmxx_hzdc.HandleDate' ;
  static $NowStatus = 'gzpc_xmxx_hzdc.NowStatus' ;
  static $CompleteDate = 'gzpc_xmxx_hzdc.CompleteDate' ;
  static $RecordTime = 'gzpc_xmxx_hzdc.RecordTime' ;
  static $UpdateTime = 'gzpc_xmxx_hzdc.UpdateTime' ;
  static $ContactNum = 'gzpc_xmxx_hzdc.ContactNum' ;
  static function all(){
            //return parent::all();
        }
}
