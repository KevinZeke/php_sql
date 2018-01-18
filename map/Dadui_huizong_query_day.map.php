<?php 
require_once __DIR__.'/DB_map.class.php';
class Dadui_huizong_query_day_map extends DB_map {
  static $table_name = 'dadui_huizong_query_day' ;
  static $number_id = 'dadui_huizong_query_day.number_id' ;
  static $police_id = 'dadui_huizong_query_day.police_id' ;
  static $police_name = 'dadui_huizong_query_day.police_name' ;
  static $year_month_show = 'dadui_huizong_query_day.year_month_show' ;
  static $quantity_score = 'dadui_huizong_query_day.quantity_score' ;
  static $quality_score = 'dadui_huizong_query_day.quality_score' ;
  static $efficiency_score = 'dadui_huizong_query_day.efficiency_score' ;
  static $capacity_score = 'dadui_huizong_query_day.capacity_score' ;
  static $effect_score = 'dadui_huizong_query_day.effect_score' ;
  static $weighted_total_score = 'dadui_huizong_query_day.weighted_total_score' ;
  static $dd_name = 'dadui_huizong_query_day.dd_name' ;
  static $zhd_name = 'dadui_huizong_query_day.zhd_name' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
