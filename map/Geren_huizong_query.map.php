<?php 
require_once __DIR__.'/DB_map.class.php';
class Geren_huizong_query_map extends DB_map {
  static $table_name = 'geren_huizong_query' ;
  static $number_id = 'geren_huizong_query.number_id' ;
  static $police_id = 'geren_huizong_query.police_id' ;
  static $police_name = 'geren_huizong_query.police_name' ;
  static $year_month_show = 'geren_huizong_query.year_month_show' ;
  static $px_tolscore = 'geren_huizong_query.px_tolscore' ;
  static $ks_score = 'geren_huizong_query.ks_score' ;
  static $quantity_score = 'geren_huizong_query.quantity_score' ;
  static $quality_score = 'geren_huizong_query.quality_score' ;
  static $efficiency_score = 'geren_huizong_query.efficiency_score' ;
  static $capacity_score = 'geren_huizong_query.capacity_score' ;
  static $effect_score = 'geren_huizong_query.effect_score' ;
  static $weighted_total_score = 'geren_huizong_query.weighted_total_score' ;
  static $dd_name = 'geren_huizong_query.dd_name' ;
  static $zhd_name = 'geren_huizong_query.zhd_name' ;
  static function all(){
            //return parent::all();
        }
}
