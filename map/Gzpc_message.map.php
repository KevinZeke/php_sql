<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_message_map extends DB_map {
  static $table_name = 'gzpc_message' ;
  static $id = 'gzpc_message.id' ;
  static $taskId = 'gzpc_message.taskId' ;
  static $xmlb = 'gzpc_message.xmlb' ;
  static $ContactNum = 'gzpc_message.ContactNum' ;
  static $status = 'gzpc_message.status' ;
  static $sendTime = 'gzpc_message.sendTime' ;
  static $returnWord = 'gzpc_message.returnWord' ;
  static $returnDate = 'gzpc_message.returnDate' ;
  static function all(){
            //return parent::all();
        }
}
