<?php 
require_once __DIR__.'/DB_map.class.php';
class Dadui_name_list_map extends DB_map {
  static $table_name = 'dadui_name_list' ;
  static $dadui_no = 'dadui_name_list.dadui_no' ;
  static $dadui_name = 'dadui_name_list.dadui_name' ;
  static $dadui_dist = 'dadui_name_list.dadui_dist' ;
  static $dadui_bh = 'dadui_name_list.dadui_bh' ;
  static $dadui_db_name = 'dadui_name_list.dadui_db_name' ;
  static $zhidui_name = 'dadui_name_list.zhidui_name' ;
  static $zongdui_name = 'dadui_name_list.zongdui_name' ;
  static function all(){
            //return parent::all();
        }
}
