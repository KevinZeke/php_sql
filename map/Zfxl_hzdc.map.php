<?php 
require_once __DIR__.'/DB_map.class.php';
class Zfxl_hzdc_map extends DB_map {
  static $table_name = 'zfxl_hzdc' ;
  static $id = 'zfxl_hzdc.id' ;
  static $name = 'zfxl_hzdc.name' ;
  static $zhidui = 'zfxl_hzdc.zhidui' ;
  static $dadui = 'zfxl_hzdc.dadui' ;
  static $XMBH = 'zfxl_hzdc.XMBH' ;
  static $xmlx = 'zfxl_hzdc.xmlx' ;
  static $QHSJ = 'zfxl_hzdc.QHSJ' ;
  static $BJSJ = 'zfxl_hzdc.BJSJ' ;
  static $JZTIME = 'zfxl_hzdc.JZTIME' ;
  static $CLTIME = 'zfxl_hzdc.CLTIME' ;
  static $OVERTIME = 'zfxl_hzdc.OVERTIME' ;
  static $Status = 'zfxl_hzdc.Status' ;
  static $CBR = 'zfxl_hzdc.CBR' ;
  static $CompleteTimeSCORE = 'zfxl_hzdc.CompleteTimeSCORE' ;
  static $CompleteTimeCount = 'zfxl_hzdc.CompleteTimeCount' ;
  static $SendToCBR = 'zfxl_hzdc.SendToCBR' ;
  static $SendToCBRCount = 'zfxl_hzdc.SendToCBRCount' ;
  static $SendToCBRJLDSCORE = 'zfxl_hzdc.SendToCBRJLDSCORE' ;
  static $SendToCBRJLDCount = 'zfxl_hzdc.SendToCBRJLDCount' ;
  static $SendToDDZDZGSCORE = 'zfxl_hzdc.SendToDDZDZGSCORE' ;
  static $SendToDDZDZGCount = 'zfxl_hzdc.SendToDDZDZGCount' ;
  static $KP_SCORE = 'zfxl_hzdc.KP_SCORE' ;
  static $KP_TRUE_SCORE = 'zfxl_hzdc.KP_TRUE_SCORE' ;
  static function all(){
            //return parent::all();
        }
}
