<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfsjbas_gr_basic_coef_map extends DB_map {
  static $table_name = 'quantity_xfsjbas_gr_basic_coef' ;
  static $sjbacchg_zddw_zhubr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbacchg_zddw_zhubr_xxqz' ;
  static $sjbacchg_zddw_xiebr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbacchg_zddw_xiebr_xxqz' ;
  static $sjbacchg_qtdw_zhubr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbacchg_qtdw_zhubr_xxqz' ;
  static $sjbacchg_qtdw_xiebr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbacchg_qtdw_xiebr_xxqz' ;
  static $sjbaccbuhg_zddw_zhubr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbaccbuhg_zddw_zhubr_xxqz' ;
  static $sjbaccbuhg_zddw_xiebr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbaccbuhg_zddw_xiebr_xxqz' ;
  static $sjbaccbuhg_qtdw_zhubr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbaccbuhg_qtdw_zhubr_xxqz' ;
  static $sjbaccbuhg_qtdw_xiebr_xxqz = 'quantity_xfsjbas_gr_basic_coef.sjbaccbuhg_qtdw_xiebr_xxqz' ;
  static $number_id = 'quantity_xfsjbas_gr_basic_coef.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
