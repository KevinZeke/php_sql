<?php 
require_once __DIR__.'/DB_map.class.php';
class Zfsp_hz_map extends DB_map {
  static $table_name = 'zfsp_hz' ;
  static $name = 'zfsp_hz.name' ;
  static $SJ = 'zfsp_hz.SJ' ;
  static $zfsp_jdjc = 'zfsp_hz.zfsp_jdjc' ;
  static $zfsp_jsys = 'zfsp_hz.zfsp_jsys' ;
  static $zfsp_bacc = 'zfsp_hz.zfsp_bacc' ;
  static $zfsp_hzdcc = 'zfsp_hz.zfsp_hzdcc' ;
  static $zfsp_xzcf = 'zfsp_hz.zfsp_xzcf' ;
  static $zfsp_jsys_truescore = 'zfsp_hz.zfsp_jsys_truescore' ;
  static $zfsp_bacc_truescore = 'zfsp_hz.zfsp_bacc_truescore' ;
  static $zfsp_jdjc_truescore = 'zfsp_hz.zfsp_jdjc_truescore' ;
  static $zfsp_hzdc_truescore = 'zfsp_hz.zfsp_hzdc_truescore' ;
  static $zfsp_xzcf_truescore = 'zfsp_hz.zfsp_xzcf_truescore' ;
  static $xzcf_lxqz = 'zfsp_hz.xzcf_lxqz' ;
  static $jdjc_lxqz = 'zfsp_hz.jdjc_lxqz' ;
  static $hzdc_lxqz = 'zfsp_hz.hzdc_lxqz' ;
  static $jsys_lxqz = 'zfsp_hz.jsys_lxqz' ;
  static $bacc_lxqz = 'zfsp_hz.bacc_lxqz' ;
  static $zfsp_hz = 'zfsp_hz.zfsp_hz' ;
  static $id = 'zfsp_hz.id' ;
  static $dd_name = 'zfsp_hz.dd_name' ;
  static $xzcf_count = 'zfsp_hz.xzcf_count' ;
  static $jsys_count = 'zfsp_hz.jsys_count' ;
  static $bacc_count = 'zfsp_hz.bacc_count' ;
  static $jdjc_count = 'zfsp_hz.jdjc_count' ;
  static $hzdc_count = 'zfsp_hz.hzdc_count' ;
  static function all(){
            //return parent::all();
        }
}
