<?php 
require_once __DIR__.'/DB_map.class.php';
class Zfxl_jdjc_map extends DB_map {
  static $table_name = 'zfxl_jdjc' ;
  static $id = 'zfxl_jdjc.id' ;
  static $name = 'zfxl_jdjc.name' ;
  static $zhidui = 'zfxl_jdjc.zhidui' ;
  static $dadui = 'zfxl_jdjc.dadui' ;
  static $XMBH = 'zfxl_jdjc.XMBH' ;
  static $xmlx = 'zfxl_jdjc.xmlx' ;
  static $DWMC = 'zfxl_jdjc.DWMC' ;
  static $JCQX = 'zfxl_jdjc.JCQX' ;
  static $JCQK = 'zfxl_jdjc.JCQK' ;
  static $OVERTIME = 'zfxl_jdjc.OVERTIME' ;
  static $CBR = 'zfxl_jdjc.CBR' ;
  static $CompleteTimeSCORE = 'zfxl_jdjc.CompleteTimeSCORE' ;
  static $CompleteTimeCount = 'zfxl_jdjc.CompleteTimeCount' ;
  static $SendToCBR = 'zfxl_jdjc.SendToCBR' ;
  static $SendToCBRCount = 'zfxl_jdjc.SendToCBRCount' ;
  static $SendToCBRJLDSCORE = 'zfxl_jdjc.SendToCBRJLDSCORE' ;
  static $SendToCBRJLDCount = 'zfxl_jdjc.SendToCBRJLDCount' ;
  static $SendToDDZDZGSCORE = 'zfxl_jdjc.SendToDDZDZGSCORE' ;
  static $SendToDDZDZGCount = 'zfxl_jdjc.SendToDDZDZGCount' ;
  static $KP_SCORE = 'zfxl_jdjc.KP_SCORE' ;
  static $KP_TRUE_SCORE = 'zfxl_jdjc.KP_TRUE_SCORE' ;
  static function all(){
            //return parent::all();
        }
}
