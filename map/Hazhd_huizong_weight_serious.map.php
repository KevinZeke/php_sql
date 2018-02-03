<?php 
require_once __DIR__.'/DB_map.class.php';
class Hazhd_huizong_weight_serious_map extends DB_map {
  static $table_name = 'hazhd_huizong_weight_serious' ;
  static $number_id = 'hazhd_huizong_weight_serious.number_id' ;
  static $quantity_weight = 'hazhd_huizong_weight_serious.quantity_weight' ;
  static $quality_weight = 'hazhd_huizong_weight_serious.quality_weight' ;
  static $efficiency_weight = 'hazhd_huizong_weight_serious.efficiency_weight' ;
  static $capacity_weight = 'hazhd_huizong_weight_serious.capacity_weight' ;
  static $effect_weight = 'hazhd_huizong_weight_serious.effect_weight' ;
  static function all(){
            //return parent::all();
        }
}
