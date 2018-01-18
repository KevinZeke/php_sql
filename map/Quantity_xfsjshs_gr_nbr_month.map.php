<?php 
require_once __DIR__.'/DB_map.class.php';
class Quantity_xfsjshs_gr_nbr_month_map extends DB_map {
  static $table_name = 'quantity_xfsjshs_gr_nbr_month' ;
  static $police_name = 'quantity_xfsjshs_gr_nbr_month.police_name' ;
  static $dadui_name = 'quantity_xfsjshs_gr_nbr_month.dadui_name' ;
  static $zhidui_name = 'quantity_xfsjshs_gr_nbr_month.zhidui_name' ;
  static $year_month_show = 'quantity_xfsjshs_gr_nbr_month.year_month_show' ;
  static $sjshhg_zddw_zhubr = 'quantity_xfsjshs_gr_nbr_month.sjshhg_zddw_zhubr' ;
  static $sjshhg_zddw_xiebr = 'quantity_xfsjshs_gr_nbr_month.sjshhg_zddw_xiebr' ;
  static $sjshhg_qtdw_zhubr = 'quantity_xfsjshs_gr_nbr_month.sjshhg_qtdw_zhubr' ;
  static $sjshhg_qtdw_xiebr = 'quantity_xfsjshs_gr_nbr_month.sjshhg_qtdw_xiebr' ;
  static $sjshbuhg_zddw_zhubr = 'quantity_xfsjshs_gr_nbr_month.sjshbuhg_zddw_zhubr' ;
  static $sjshbuhg_zddw_xiebr = 'quantity_xfsjshs_gr_nbr_month.sjshbuhg_zddw_xiebr' ;
  static $sjshbuhg_qtdw_zhubr = 'quantity_xfsjshs_gr_nbr_month.sjshbuhg_qtdw_zhubr' ;
  static $sjshbuhg_qtdw_xiebr = 'quantity_xfsjshs_gr_nbr_month.sjshbuhg_qtdw_xiebr' ;
  static $police_id = 'quantity_xfsjshs_gr_nbr_month.police_id' ;
  static $number_id = 'quantity_xfsjshs_gr_nbr_month.number_id' ;
  static function all(){
            return parent::all(__CLASS__);
        }
}
