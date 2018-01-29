<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/27
 * Time: 18:41
 */

require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/../formula/Table_gropu.interface.php';
require_once __DIR__ . '/../formula/HZ.php';
require_once __DIR__ . '/../formula/JDJC.php';
require_once __DIR__ . '/../formula/JSYS.php';

//echo Table_group::format_date('a','%212%');

$sqltool = SqlTool::build();
$mysqli = $sqltool->get_mysqli();
$name = '汤金保';
$id = 10086;
$date = '2017-05-01';
$date_arr = ['2017-05-01', '2017-06-09'];

if (false) {
//    HZ_group::hz_clear($mysqli, $date_arr);

//    HZ_group::insert_jsys($mysqli);
//    HZ_group::insert_xzcf($mysqli);
//    HZ_group::insert_hzdc($mysqli);
//    HZ_group::insert_jdjc($mysqli);
//
//    HZ_group::insert_hzdc_item($mysqli, $name, $date);
//    HZ_group::insert_jdjc_item($mysqli, $name, $date);
//    HZ_group::insert_jsys_item($mysqli, $name, $date);
//    HZ_group::insert_xzcf_item($mysqli, $name, $date);
//
//    HZ_group::insert_hzdc_item($mysqli, $name, $date_arr);
//    HZ_group::insert_jdjc_item($mysqli, $name, $date_arr);
//    HZ_group::insert_jsys_item($mysqli, $name, $date_arr);
//    HZ_group::insert_xzcf_item($mysqli, $name, $date_arr);

//
//    HZ_group::update_hzdc_item($mysqli, $name, $date);
//    HZ_group::update_jdjc_item($mysqli, $name, $date);
//    HZ_group::update_jsys_item($mysqli, $name, $date);
//    HZ_group::update_xzcf_item($mysqli, $name, $date);

//    HZ_group::insert_hzdc_by_date($mysqli, '2017-05-01');
//    HZ_group::insert_hzdc_by_date($mysqli, '%2017-05-01%');
//    HZ_group::insert_hzdc_by_date($mysqli, ['2017-05-01', '2017-08-09']);

//    HZ_group::update_xzcf_by_date($mysqli,$date_arr);
//    HZ_group::update_xzcf_by_date($mysqli,$date);
//    HZ_group::update_hzdc_by_date($mysqli,$date_arr);
//    HZ_group::update_hzdc_by_date($mysqli,$date);
//    HZ_group::update_jsys_by_date($mysqli,$date_arr);
//    HZ_group::update_jsys_by_date($mysqli,$date);
//    HZ_group::update_jdjc_by_date($mysqli,$date_arr);
//    HZ_group::update_jdjc_by_date($mysqli,$date);

}

if (1) {
//    JDJC_group::jdjc_insert_jcdw($mysqli);
//    JDJC_group::jdjc_insert_xfls($mysqli);
//    JDJC_group::jdjc_insert_fxhz($mysqli);
//    JDJC_group::jdjc_insert_dczg($mysqli);

//    JDJC_group::jdjc_insert_jcdw_item($mysqli, $name, $date);
//    JDJC_group::jdjc_insert_xfls_item($mysqli, $name, $date);
//    JDJC_group::jdjc_insert_fxhz_item($mysqli, $name, $date);
//    JDJC_group::jdjc_insert_dczg_item($mysqli, $name, $date);

//    JDJC_group::jdjc_insert_jcdw_item($mysqli, $name, $date_arr);
//    JDJC_group::jdjc_insert_xfls_item($mysqli, $name, $date_arr);
//    JDJC_group::jdjc_insert_fxhz_item($mysqli, $name, $date_arr);
//    JDJC_group::jdjc_insert_dczg_item($mysqli, $name, $date_arr);


//    JDJC_group::jdjc_update_dczg_item($mysqli, $name, $date);
//    JDJC_group::jdjc_update_xfls_item($mysqli, $name, $date);
//    JDJC_group::jdjc_update_dczg_item($mysqli, $name, $date);
//    JDJC_group::jdjc_update_fxhz_item($mysqli, $name, $date);

//    JDJC_group::jcdw_sub_update($mysqli,'');
//    JDJC_group::xfls_sub_update($mysqli,'');
//    JDJC_group::fxhz_sub_update($mysqli,'');
//    JDJC_group::dczg_sub_update($mysqli,'');

//    JDJC_group::dczg_sub_update_by_id($mysqli, $id);
//    JDJC_group::jcdw_sub_update_by_id($mysqli, $id);
//    JDJC_group::xfls_sub_update_by_id($mysqli, $id);
//    JDJC_group::fxhz_sub_update_by_id($mysqli, $id);

//    JDJC_group::jcdw_sub_update_date_in($mysqli, $date_arr);
//    JDJC_group::dczg_sub_update_date_in($mysqli, $date_arr);
//    JDJC_group::xfls_sub_update_date_in($mysqli, $date_arr);
//    JDJC_group::fxhz_sub_update_date_in($mysqli, $date_arr);

//    JDJC_group::update_dczg_by_date($mysqli,$date_arr);
//    JDJC_group::update_dczg_by_date($mysqli,$date);
//    JDJC_group::update_xfls_by_date($mysqli,$date_arr);
//    JDJC_group::update_xfls_by_date($mysqli,$date);
//    JDJC_group::update_fxhz_by_date($mysqli,$date_arr);
//    JDJC_group::update_fxhz_by_date($mysqli,$date);
//    JDJC_group::update_jcdw_by_date($mysqli,$date_arr);
//    JDJC_group::update_jcdw_by_date($mysqli,$date);

}


if (false) {
//    JSYS_group::jianshen_insert_ba($mysqli,'');
//    JSYS_group::jianshen_insert_ys($mysqli,'');
//    JSYS_group::jianshen_insert_jg($mysqli,'');
//    JSYS_group::jianshen_insert_sh($mysqli,'');

//    JSYS_group::jianshen_insert_jg_item($mysqli,$name,$date);
//    JSYS_group::jianshen_insert_ys_item($mysqli,$name,$date);
//    JSYS_group::jianshen_insert_ba_item($mysqli,$name,$date);
//    JSYS_group::jianshen_insert_sh_item($mysqli,$name,$date);
//
//    JSYS_group::jianshen_insert_jg_item($mysqli,$name,$date_arr);
//    JSYS_group::jianshen_insert_ys_item($mysqli,$name,$date_arr);
//    JSYS_group::jianshen_insert_ba_item($mysqli,$name,$date_arr);
//    JSYS_group::jianshen_insert_sh_item($mysqli,$name,$date_arr);

//    JSYS_group::ys_sub_update($mysqli,' ');
//    JSYS_group::jg_sub_update($mysqli,' ');
//    JSYS_group::ba_sub_update($mysqli,' ');
//    JSYS_group::sh_sub_update($mysqli,' ');

//    JSYS_group::jg_sub_update_by_id($mysqli,$id);
//    JSYS_group::ys_sub_update_by_id($mysqli,$id);
//    JSYS_group::ba_sub_update_by_id($mysqli,$id);
//    JSYS_group::sh_sub_update_by_id($mysqli,$id);

//    JSYS_group::jg_sub_update_date_in($mysqli,$date_arr);
//    JSYS_group::sh_sub_update_date_in($mysqli,$date_arr);
//    JSYS_group::ys_sub_update_date_in($mysqli,$date_arr);
//    JSYS_group::ba_sub_update_date_in($mysqli,$date_arr);

//    JSYS_group::jianshen_update_sh_by_date($mysqli, $date_arr);
//    JSYS_group::jianshen_update_sh_by_date($mysqli, $date);
//    JSYS_group::jianshen_update_ba_by_date($mysqli, $date_arr);
//    JSYS_group::jianshen_update_ba_by_date($mysqli, $date);
//    JSYS_group::jianshen_update_jg_by_date($mysqli, $date_arr);
//    JSYS_group::jianshen_update_jg_by_date($mysqli, $date);
//    JSYS_group::jianshen_update_ys_by_date($mysqli, $date_arr);
//    JSYS_group::jianshen_update_ys_by_date($mysqli, $date);

}


//HZ_group::insert_hzdc($mysqli);
//HZ_group::insert_xzcf($mysqli);

//HZ_group::insert_jsys($mysqli);
//HZ_group::insert_jdjc($mysqli);

//HZ_group::group_insert($mysqli, ['2017-04-01', '2017-04-30']);

JDJC_group::group_insert($mysqli, $date);

//JDJC_group::group_insert($mysqli, $date_arr);

//JSYS_group::group_insert($mysqli,$date_arr);

$sqltool->close();