<?php 
require_once __DIR__.'/DB_map.class.php';
class Hazhd_huizong_query_map extends DB_map {
  static $table_name = 'hazhd_huizong_query' ;
  static $number_id = 'hazhd_huizong_query.number_id' ;
  static $dadui_name = 'hazhd_huizong_query.dadui_name' ;
  static $year_month_show = 'hazhd_huizong_query.year_month_show' ;
  static $quantity_score = 'hazhd_huizong_query.quantity_score' ;
  static $quality_score = 'hazhd_huizong_query.quality_score' ;
  static $efficiency_score = 'hazhd_huizong_query.efficiency_score' ;
  static $capacity_score = 'hazhd_huizong_query.capacity_score' ;
  static $effect_score = 'hazhd_huizong_query.effect_score' ;
  static $weighted_total_score = 'hazhd_huizong_query.weighted_total_score' ;
  static function all(){
            //return parent::all();
        }
}
