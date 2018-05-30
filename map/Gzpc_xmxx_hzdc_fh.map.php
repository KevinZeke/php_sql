<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_xmxx_hzdc_fh_map extends DB_map {
  static $table_name = 'gzpc_xmxx_hzdc_fh' ;
  static $id = 'gzpc_xmxx_hzdc_fh.id' ;
  static $taskId = 'gzpc_xmxx_hzdc_fh.taskId' ;
  static $HzdcType = 'gzpc_xmxx_hzdc_fh.HzdcType' ;
  static $OldtaskId = 'gzpc_xmxx_hzdc_fh.OldtaskId' ;
  static $FirePart = 'gzpc_xmxx_hzdc_fh.FirePart' ;
  static $FireAddress = 'gzpc_xmxx_hzdc_fh.FireAddress' ;
  static $Director = 'gzpc_xmxx_hzdc_fh.Director' ;
  static $CreatDate = 'gzpc_xmxx_hzdc_fh.CreatDate' ;
  static $HandleDate = 'gzpc_xmxx_hzdc_fh.HandleDate' ;
  static $NowStatus = 'gzpc_xmxx_hzdc_fh.NowStatus' ;
  static $CompleteDate = 'gzpc_xmxx_hzdc_fh.CompleteDate' ;
  static $RecordTime = 'gzpc_xmxx_hzdc_fh.RecordTime' ;
  static $UpdateTime = 'gzpc_xmxx_hzdc_fh.UpdateTime' ;
  static $ContactNum = 'gzpc_xmxx_hzdc_fh.ContactNum' ;
  static function all(){
            //return parent::all();
        }
}
