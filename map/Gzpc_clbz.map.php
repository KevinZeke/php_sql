<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_clbz_map extends DB_map {
  static $table_name = 'gzpc_clbz' ;
  static $id = 'gzpc_clbz.id' ;
  static $part = 'gzpc_clbz.part' ;
  static $content = 'gzpc_clbz.content' ;
  static $parentId = 'gzpc_clbz.parentId' ;
  static $moneyMin = 'gzpc_clbz.moneyMin' ;
  static $moneyMax = 'gzpc_clbz.moneyMax' ;
  static $moneyMinExpand = 'gzpc_clbz.moneyMinExpand' ;
  static $moneyMaxExpand = 'gzpc_clbz.moneyMaxExpand' ;
  static $expandCondition = 'gzpc_clbz.expandCondition' ;
  static $expandConditionOperator = 'gzpc_clbz.expandConditionOperator' ;
  static $expandConditionValue = 'gzpc_clbz.expandConditionValue' ;
  static $moneyPlus = 'gzpc_clbz.moneyPlus' ;
  static $plusCondition = 'gzpc_clbz.plusCondition' ;
  static $plusConditionOperator = 'gzpc_clbz.plusConditionOperator' ;
  static $plusConditionValue = 'gzpc_clbz.plusConditionValue' ;
  static $type = 'gzpc_clbz.type' ;
  static $elementName = 'gzpc_clbz.elementName' ;
  static $remark = 'gzpc_clbz.remark' ;
  static function all(){
            //return parent::all();
        }
}
