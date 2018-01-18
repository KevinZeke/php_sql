<?php 
require_once __DIR__.'/DB_map.class.php';
class Jianshenyanshou_gr_score_month_map extends DB_map {
  static $table_name = 'jianshenyanshou_gr_score_month' ;
  static $police_name = 'jianshenyanshou_gr_score_month.police_name' ;
  static $police_id = 'jianshenyanshou_gr_score_month.police_id' ;
  static $year_month_show = 'jianshenyanshou_gr_score_month.year_month_show' ;
  static $sjshs_df = 'jianshenyanshou_gr_score_month.sjshs_df' ;
  static $xfyss_df = 'jianshenyanshou_gr_score_month.xfyss_df' ;
  static $sjbas_df = 'jianshenyanshou_gr_score_month.sjbas_df' ;
  static $jgysbas_df = 'jianshenyanshou_gr_score_month.jgysbas_df' ;
  static $jsys_zdf = 'jianshenyanshou_gr_score_month.jsys_zdf' ;
  static $zhidui_rank = 'jianshenyanshou_gr_score_month.zhidui_rank' ;
  static $total_zhidui_staff_nbr = 'jianshenyanshou_gr_score_month.total_zhidui_staff_nbr' ;
  static $number_id = 'jianshenyanshou_gr_score_month.number_id' ;
  static $dd_name = 'jianshenyanshou_gr_score_month.dd_name' ;
  static $zhd_name = 'jianshenyanshou_gr_score_month.zhd_name' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
