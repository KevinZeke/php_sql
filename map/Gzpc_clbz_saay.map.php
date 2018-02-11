<?php 
require_once __DIR__.'/DB_map.class.php';
class Gzpc_clbz_saay_map extends DB_map {
  static $table_name = 'gzpc_clbz_saay' ;
  static $id = 'gzpc_clbz_saay.id' ;
  static $name = 'gzpc_clbz_saay.name' ;
  static $relatedIds = 'gzpc_clbz_saay.relatedIds' ;
  static $itemName = 'gzpc_clbz_saay.itemName' ;
  static function all(){
            //return parent::all();
        }
}
