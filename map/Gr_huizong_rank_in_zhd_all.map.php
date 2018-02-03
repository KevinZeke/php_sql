<?php 
require_once __DIR__.'/DB_map.class.php';
class Gr_huizong_rank_in_zhd_all_map extends DB_map {
  static $table_name = 'gr_huizong_rank_in_zhd_all' ;
  static $police_name = 'gr_huizong_rank_in_zhd_all.police_name' ;
  static $dd_name = 'gr_huizong_rank_in_zhd_all.dd_name' ;
  static $zhd_name = 'gr_huizong_rank_in_zhd_all.zhd_name' ;
  static $total_score = 'gr_huizong_rank_in_zhd_all.total_score' ;
  static $rank = 'gr_huizong_rank_in_zhd_all.rank' ;
  static $total_number = 'gr_huizong_rank_in_zhd_all.total_number' ;
  static $year_month_show = 'gr_huizong_rank_in_zhd_all.year_month_show' ;
  static $number_id = 'gr_huizong_rank_in_zhd_all.number_id' ;
  static function all(){
            //return parent::all();
        }
}
