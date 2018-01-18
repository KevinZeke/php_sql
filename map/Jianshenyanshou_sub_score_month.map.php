<?php 
require_once __DIR__.'/DB_map.class.php';
class Jianshenyanshou_sub_score_month_map extends DB_map {
  static $table_name = 'jianshenyanshou_sub_score_month' ;
  static $police_name = 'jianshenyanshou_sub_score_month.police_name' ;
  static $police_id = 'jianshenyanshou_sub_score_month.police_id' ;
  static $year_month_show = 'jianshenyanshou_sub_score_month.year_month_show' ;
  static $sjshs_score = 'jianshenyanshou_sub_score_month.sjshs_score' ;
  static $xfyss_score = 'jianshenyanshou_sub_score_month.xfyss_score' ;
  static $sjbas_score = 'jianshenyanshou_sub_score_month.sjbas_score' ;
  static $jgysbas_score = 'jianshenyanshou_sub_score_month.jgysbas_score' ;
  static $number_id = 'jianshenyanshou_sub_score_month.number_id' ;
  static $dd_name = 'jianshenyanshou_sub_score_month.dd_name' ;
  static $zhd_name = 'jianshenyanshou_sub_score_month.zhd_name' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
