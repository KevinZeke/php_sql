<?php 
require_once __DIR__.'/DB_map.class.php';
class Jianshenyanshou_sub_score_map extends DB_map {
  static $table_name = 'jianshenyanshou_sub_score' ;
  static $police_name = 'jianshenyanshou_sub_score.police_name' ;
  static $police_id = 'jianshenyanshou_sub_score.police_id' ;
  static $year_month_show = 'jianshenyanshou_sub_score.year_month_show' ;
  static $sjshs_score = 'jianshenyanshou_sub_score.sjshs_score' ;
  static $xfyss_score = 'jianshenyanshou_sub_score.xfyss_score' ;
  static $sjbas_score = 'jianshenyanshou_sub_score.sjbas_score' ;
  static $jgysbas_score = 'jianshenyanshou_sub_score.jgysbas_score' ;
  static $number_id = 'jianshenyanshou_sub_score.number_id' ;
  static $dd_name = 'jianshenyanshou_sub_score.dd_name' ;
  static $zhd_name = 'jianshenyanshou_sub_score.zhd_name' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
