<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfsjbas_gr_nbr_month_map extends DB_map {
  static $table_name = 'quantity_xfsjbas_gr_nbr_month' ;
  static $police_name = 'quantity_xfsjbas_gr_nbr_month.police_name' ;
  static $dadui_name = 'quantity_xfsjbas_gr_nbr_month.dadui_name' ;
  static $zhidui_name = 'quantity_xfsjbas_gr_nbr_month.zhidui_name' ;
  static $year_month_show = 'quantity_xfsjbas_gr_nbr_month.year_month_show' ;
  static $sjbacchg_zddw_zhubr = 'quantity_xfsjbas_gr_nbr_month.sjbacchg_zddw_zhubr' ;
  static $sjbacchg_zddw_xiebr = 'quantity_xfsjbas_gr_nbr_month.sjbacchg_zddw_xiebr' ;
  static $sjbacchg_qtdw_zhubr = 'quantity_xfsjbas_gr_nbr_month.sjbacchg_qtdw_zhubr' ;
  static $sjbacchg_qtdw_xiebr = 'quantity_xfsjbas_gr_nbr_month.sjbacchg_qtdw_xiebr' ;
  static $sjbaccbuhg_zddw_zhubr = 'quantity_xfsjbas_gr_nbr_month.sjbaccbuhg_zddw_zhubr' ;
  static $sjbaccbuhg_zddw_xiebr = 'quantity_xfsjbas_gr_nbr_month.sjbaccbuhg_zddw_xiebr' ;
  static $sjbaccbuhg_qtdw_zhubr = 'quantity_xfsjbas_gr_nbr_month.sjbaccbuhg_qtdw_zhubr' ;
  static $sjbaccbuhg_qtdw_xiebr = 'quantity_xfsjbas_gr_nbr_month.sjbaccbuhg_qtdw_xiebr' ;
  static $police_id = 'quantity_xfsjbas_gr_nbr_month.police_id' ;
  static $number_id = 'quantity_xfsjbas_gr_nbr_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
