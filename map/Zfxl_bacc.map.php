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
  static $cbr_qz = 'zfxl_bacc.cbr_qz' ;
  static $ffbzgl_zfxl_1 = 'zfxl_bacc.ffbzgl_zfxl_1' ;
  static $CompleteTimeCount = 'zfxl_bacc.CompleteTimeCount' ;
  static $ffbzgl_zfxl_cbr2 = 'zfxl_bacc.ffbzgl_zfxl_cbr2' ;
  static $SendToCBRCount = 'zfxl_bacc.SendToCBRCount' ;
  static $ffbzgl_zfxl_ld3 = 'zfxl_bacc.ffbzgl_zfxl_ld3' ;
  static $SendToCBRJLDCount = 'zfxl_bacc.SendToCBRJLDCount' ;
  static $ffbzgl_zfxl_zg4 = 'zfxl_bacc.ffbzgl_zfxl_zg4' ;
  static $SendToDDZDZGCount = 'zfxl_bacc.SendToDDZDZGCount' ;
  static $KP_SCORE = 'zfxl_bacc.KP_SCORE' ;
  static $KP_TRUE_SCORE = 'zfxl_bacc.KP_TRUE_SCORE' ;
  static function all(){
            //return parent::all();
        }
}
