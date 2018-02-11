<?php 
require_once __DIR__.'/DB_map.class.php';
class Kpdf_xlkp_map extends DB_map {
  static $table_name = 'kpdf_xlkp' ;
  static $Item_num = 'kpdf_xlkp.Item_num' ;
  static $ItemType = 'kpdf_xlkp.ItemType' ;
  static $StartTime = 'kpdf_xlkp.StartTime' ;
  static $EndTime = 'kpdf_xlkp.EndTime' ;
  static $CompleteTime = 'kpdf_xlkp.CompleteTime' ;
  static $CompleteTimeCount = 'kpdf_xlkp.CompleteTimeCount' ;
  static $CompleteTimeSCORE = 'kpdf_xlkp.CompleteTimeSCORE' ;
  static $SendToCBRCount = 'kpdf_xlkp.SendToCBRCount' ;
  static $SendToCBRSCORE = 'kpdf_xlkp.SendToCBRSCORE' ;
  static $SendToCBRJLDCount = 'kpdf_xlkp.SendToCBRJLDCount' ;
  static $SendToCBRJLDSCORE = 'kpdf_xlkp.SendToCBRJLDSCORE' ;
  static $SendToDDZDZGCount = 'kpdf_xlkp.SendToDDZDZGCount' ;
  static $SendToDDZDZGSCORE = 'kpdf_xlkp.SendToDDZDZGSCORE' ;
  static $xlkp_Result = 'kpdf_xlkp.xlkp_Result' ;
  static $num_id = 'kpdf_xlkp.num_id' ;
  static function all(){
            //return parent::all();
        }
}
