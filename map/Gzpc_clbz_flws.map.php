<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_clbz_flws_map extends DB_map {
  static $table_name = 'gzpc_clbz_flws' ;
  static $id = 'gzpc_clbz_flws.id' ;
  static $taskId = 'gzpc_clbz_flws.taskId' ;
  static $itemId = 'gzpc_clbz_flws.itemId' ;
  static $relatedItemId = 'gzpc_clbz_flws.relatedItemId' ;
  static $clbzSelectRadio = 'gzpc_clbz_flws.clbzSelectRadio' ;
  static $clbzSelectCheckBox = 'gzpc_clbz_flws.clbzSelectCheckBox' ;
  static $clbzPersonNum = 'gzpc_clbz_flws.clbzPersonNum' ;
  static $clbzUnitType = 'gzpc_clbz_flws.clbzUnitType' ;
  static $clbzMoneyMin = 'gzpc_clbz_flws.clbzMoneyMin' ;
  static $clbzMoneyMax = 'gzpc_clbz_flws.clbzMoneyMax' ;
  static $clbzMoney = 'gzpc_clbz_flws.clbzMoney' ;
  static $createTime = 'gzpc_clbz_flws.createTime' ;
  static function all(){
            //return parent::all();
        }
}
