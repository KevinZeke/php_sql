<?php 
require_once __DIR__.'/DB_map.class.php';
class Kpdf_cgs_map extends DB_map {
  static $table_name = 'kpdf_cgs' ;
  static $Item_num = 'kpdf_cgs.Item_num' ;
  static $kptime = 'kpdf_cgs.kptime' ;
  static $WenShu_id = 'kpdf_cgs.WenShu_id' ;
  static $wenshuname = 'kpdf_cgs.wenshuname' ;
  static $Most_Kf = 'kpdf_cgs.Most_Kf' ;
  static $cgs_a = 'kpdf_cgs.cgs_a' ;
  static $cgs_b = 'kpdf_cgs.cgs_b' ;
  static $cgs_c = 'kpdf_cgs.cgs_c' ;
  static $cgs_d = 'kpdf_cgs.cgs_d' ;
  static $cgs_e = 'kpdf_cgs.cgs_e' ;
  static $cgs_f = 'kpdf_cgs.cgs_f' ;
  static $cgs_g = 'kpdf_cgs.cgs_g' ;
  static $cgs_h = 'kpdf_cgs.cgs_h' ;
  static $cgs_Sum = 'kpdf_cgs.cgs_Sum' ;
  static $cgs_Result = 'kpdf_cgs.cgs_Result' ;
  static $num_id = 'kpdf_cgs.num_id' ;
  static function all(){
            //return parent::all();
        }
}
