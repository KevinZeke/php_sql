<?php 
require_once __DIR__.'/DB_map.class.php';
class Kpdf_other_map extends DB_map {
  static $table_name = 'kpdf_other' ;
  static $Item_num = 'kpdf_other.Item_num' ;
  static $kptime = 'kpdf_other.kptime' ;
  static $WenShu_id = 'kpdf_other.WenShu_id' ;
  static $Most_Kf = 'kpdf_other.Most_Kf' ;
  static $other_a = 'kpdf_other.other_a' ;
  static $other_b = 'kpdf_other.other_b' ;
  static $other_c = 'kpdf_other.other_c' ;
  static $other_Result = 'kpdf_other.other_Result' ;
  static $num_id = 'kpdf_other.num_id' ;
  static function all(){
            //return parent::all();
        }
}
