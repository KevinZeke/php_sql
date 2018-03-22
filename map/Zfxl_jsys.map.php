<?php 
require_once __DIR__.'/DB_map.class.php';
class Zfxl_jsys_map extends DB_map {
  static $table_name = 'zfxl_jsys' ;
  static $id = 'zfxl_jsys.id' ;
  static $name = 'zfxl_jsys.name' ;
  static $zhidui = 'zfxl_jsys.zhidui' ;
  static $dadui = 'zfxl_jsys.dadui' ;
  static $XMBH = 'zfxl_jsys.XMBH' ;
  static $GCMC = 'zfxl_jsys.GCMC' ;
  static $XMZT = 'zfxl_jsys.XMZT' ;
  static $SLSJ = 'zfxl_jsys.SLSJ' ;
  static $CBR = 'zfxl_jsys.CBR' ;
  static $cbr_qz = 'zfxl_jsys.cbr_qz' ;
  static $overtime = 'zfxl_jsys.overtime' ;
  static $ffbzgl_zfxl_1 = 'zfxl_jsys.ffbzgl_zfxl_1' ;
  static $CompleteTimeCount = 'zfxl_jsys.CompleteTimeCount' ;
  static $ffbzgl_zfxl_cbr2 = 'zfxl_jsys.ffbzgl_zfxl_cbr2' ;
  static $SendToCBRCount = 'zfxl_jsys.SendToCBRCount' ;
  static $ffbzgl_zfxl_ld3 = 'zfxl_jsys.ffbzgl_zfxl_ld3' ;
  static $SendToCBRJLDCount = 'zfxl_jsys.SendToCBRJLDCount' ;
  static $ffbzgl_zfxl_zg4 = 'zfxl_jsys.ffbzgl_zfxl_zg4' ;
  static $SendToDDZDZGCount = 'zfxl_jsys.SendToDDZDZGCount' ;
  static $KP_SCORE = 'zfxl_jsys.KP_SCORE' ;
  static $KP_TRUE_SCORE = 'zfxl_jsys.KP_TRUE_SCORE' ;
  static function all(){
            //return parent::all();
        }
}
