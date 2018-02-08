<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_remind_status_map extends DB_map {
  static $table_name = 'gzpc_remind_status' ;
  static $id = 'gzpc_remind_status.id' ;
  static $startTime = 'gzpc_remind_status.startTime' ;
  static $limitTime = 'gzpc_remind_status.limitTime' ;
  static $director = 'gzpc_remind_status.director' ;
  static $remindType = 'gzpc_remind_status.remindType' ;
  static $receiver = 'gzpc_remind_status.receiver' ;
  static $phone = 'gzpc_remind_status.phone' ;
  static $relatedTable = 'gzpc_remind_status.relatedTable' ;
  static $relatedId = 'gzpc_remind_status.relatedId' ;
  static $content = 'gzpc_remind_status.content' ;
  static $createTime = 'gzpc_remind_status.createTime' ;
  static $status = 'gzpc_remind_status.status' ;
  static $sendTime = 'gzpc_remind_status.sendTime' ;
  static $stage = 'gzpc_remind_status.stage' ;
  static function all(){
            //return parent::all();
        }
}
