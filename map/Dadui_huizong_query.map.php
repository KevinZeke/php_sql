<?php 
require_once __DIR__.'/DB_map.class.php';
class Dadui_huizong_query_map extends DB_map {
  static $table_name = 'dadui_huizong_query' ;
  static $number_id = 'dadui_huizong_query.number_id' ;
  static $police_id = 'dadui_huizong_query.police_id' ;
  static $police_name = 'dadui_huizong_query.police_name' ;
  static $year_month_show = 'dadui_huizong_query.year_month_show' ;
  static $quantity_score = 'dadui_huizong_query.quantity_score' ;
  static $quality_score = 'dadui_huizong_query.quality_score' ;
  static $efficiency_score = 'dadui_huizong_query.efficiency_score' ;
  static $capacity_score = 'dadui_huizong_query.capacity_score' ;
  static $effect_score = 'dadui_huizong_query.effect_score' ;
  static $weighted_total_score = 'dadui_huizong_query.weighted_total_score' ;
  static $dd_name = 'dadui_huizong_query.dd_name' ;
  static $zhd_name = 'dadui_huizong_query.zhd_name' ;
  static $rank = 'dadui_huizong_query.rank' ;
  static $quantity_rank = 'dadui_huizong_query.quantity_rank' ;
  static $quality_rank = 'dadui_huizong_query.quality_rank' ;
  static $efficiency_rank = 'dadui_huizong_query.efficiency_rank' ;
  static $capacity_rank = 'dadui_huizong_query.capacity_rank' ;
  static $effect_rank = 'dadui_huizong_query.effect_rank' ;
  static function all(){
            //return parent::all();
        }
}
