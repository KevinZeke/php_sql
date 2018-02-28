<?php 
require_once __DIR__.'/DB_map.class.php';
class Zfxl_bacc_map extends DB_map {
  static $table_name = 'zfxl_bacc' ;
  static $id = 'zfxl_bacc.id' ;
  static $name = 'zfxl_bacc.name' ;
  static $zhidui = 'zfxl_bacc.zhidui' ;
  static $dadui = 'zfxl_bacc.dadui' ;
  static $XMBH = 'zfxl_bacc.XMBH' ;
  static $GCMC = 'zfxl_bacc.GCMC' ;
  static $XMJG = 'zfxl_bacc.XMJG' ;
  static $SLSJ = 'zfxl_bacc.SLSJ' ;
  static $JGYS = 'zfxl_bacc.JGYS' ;
  static $overtime = 'zfxl_bacc.overtime' ;
  static $CBR = 'zfxl_bacc.CBR' ;
  static $CompleteTimeSCORE = 'zfxl_bacc.CompleteTimeSCORE' ;
  static $CompleteTimeCount = 'zfxl_bacc.CompleteTimeCount' ;
  static $SendToCBR = 'zfxl_bacc.SendToCBR' ;
  static $SendToCBRCount = 'zfxl_bacc.SendToCBRCount' ;
  static $SendToCBRJLDSCORE = 'zfxl_bacc.SendToCBRJLDSCORE' ;
  static $SendToCBRJLDCount = 'zfxl_bacc.SendToCBRJLDCount' ;
  static $SendToDDZDZGSCORE = 'zfxl_bacc.SendToDDZDZGSCORE' ;
  static $SendToDDZDZGCount = 'zfxl_bacc.SendToDDZDZGCount' ;
  static $KP_SCORE = 'zfxl_bacc.KP_SCORE' ;
  static $KP_TRUE_SCORE = 'zfxl_bacc.KP_TRUE_SCORE' ;
  static function all(){
            //return parent::all();
        }
}
