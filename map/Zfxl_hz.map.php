<?php 
require_once __DIR__.'/DB_map.class.php';
class Zfxl_hz_map extends DB_map {
  static $table_name = 'zfxl_hz' ;
  static $name = 'zfxl_hz.name' ;
  static $SJ = 'zfxl_hz.SJ' ;
  static $dadui = 'zfxl_hz.dadui' ;
  static $zfxl_jdjc = 'zfxl_hz.zfxl_jdjc' ;
  static $zfxl_jsys = 'zfxl_hz.zfxl_jsys' ;
  static $zfxl_bacc = 'zfxl_hz.zfxl_bacc' ;
  static $zfxl_hzdcc = 'zfxl_hz.zfxl_hzdcc' ;
  static $zfxl_xzcf = 'zfxl_hz.zfxl_xzcf' ;
  static $zfxl_jsys_truescore = 'zfxl_hz.zfxl_jsys_truescore' ;
  static $zfxl_bacc_truescore = 'zfxl_hz.zfxl_bacc_truescore' ;
  static $zfxl_jdjc_truescore = 'zfxl_hz.zfxl_jdjc_truescore' ;
  static $zfxl_hzdc_truescore = 'zfxl_hz.zfxl_hzdc_truescore' ;
  static $zfxl_xzcf_truescore = 'zfxl_hz.zfxl_xzcf_truescore' ;
  static $bacc_lxqz = 'zfxl_hz.bacc_lxqz' ;
  static $hzdc_lxqz = 'zfxl_hz.hzdc_lxqz' ;
  static $jdjc_lxqz = 'zfxl_hz.jdjc_lxqz' ;
  static $jsys_lxqz = 'zfxl_hz.jsys_lxqz' ;
  static $xzcf_lxqz = 'zfxl_hz.xzcf_lxqz' ;
  static $zfxl_hz = 'zfxl_hz.zfxl_hz' ;
  static $id = 'zfxl_hz.id' ;
  static $xzcf_count = 'zfxl_hz.xzcf_count' ;
  static $jsys_count = 'zfxl_hz.jsys_count' ;
  static $bacc_count = 'zfxl_hz.bacc_count' ;
  static $jdjc_count = 'zfxl_hz.jdjc_count' ;
  static $hzdc_count = 'zfxl_hz.hzdc_count' ;
  static function all(){
            //return parent::all();
        }
}
