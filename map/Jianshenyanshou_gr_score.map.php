<?php 
require_once __DIR__.'/DB_map.class.php';
class Jianshenyanshou_gr_score_map extends DB_map {
  static $table_name = 'jianshenyanshou_gr_score' ;
  static $police_name = 'jianshenyanshou_gr_score.police_name' ;
  static $police_id = 'jianshenyanshou_gr_score.police_id' ;
  static $year_month_show = 'jianshenyanshou_gr_score.year_month_show' ;
  static $sjshs_df = 'jianshenyanshou_gr_score.sjshs_df' ;
  static $xfyss_df = 'jianshenyanshou_gr_score.xfyss_df' ;
  static $sjbas_df = 'jianshenyanshou_gr_score.sjbas_df' ;
  static $jgysbas_df = 'jianshenyanshou_gr_score.jgysbas_df' ;
  static $jsys_zdf = 'jianshenyanshou_gr_score.jsys_zdf' ;
  static $zhidui_rank = 'jianshenyanshou_gr_score.zhidui_rank' ;
  static $total_zhidui_staff_nbr = 'jianshenyanshou_gr_score.total_zhidui_staff_nbr' ;
  static $number_id = 'jianshenyanshou_gr_score.number_id' ;
  static $dd_name = 'jianshenyanshou_gr_score.dd_name' ;
  static $zhd_name = 'jianshenyanshou_gr_score.zhd_name' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
