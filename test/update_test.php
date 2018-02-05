<?php
require_once __DIR__ . "/../sql/Sql.class.php";
require_once __DIR__ . "/../Quantity/JSYS.php";
require_once __DIR__ . "/../Quantity/JDJC.php";
require_once __DIR__ . "/../Quantity/XZCF.php";
require_once __DIR__ . "/../Quantity/HZDC.php";
require_once __DIR__ . "/../Quantity/HZ.php";


$sqltool = Sql_tool::build();
$mysqli = $sqltool->get_mysqli();
Sql_tool::$isDev = true;
$date_arr = ['2017-01-01', '2017-12-30'];


if (false) {
    JSYS_group::jg_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::sh_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::ys_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::ba_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_jg_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_sh_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_ba_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_ys_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    HZ_group::update_jsys_by_date($mysqli, ['2017-01-01', '2017-12-30']);
}


if (false) {
    Sql_tool::$isDev = true;
    JDJC_group::jcdw_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::dczg_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::fxhz_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::xfls_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::jdjc_update_jcdw_by_date($mysqli, $date_arr);
    JDJC_group::jdjc_update_dczg_by_date($mysqli, $date_arr);
    JDJC_group::jdjc_update_fxhz_by_date($mysqli, $date_arr);
    JDJC_group::jdjc_update_xfls_by_date($mysqli, $date_arr);
    HZ_group::update_jdjc_by_date($mysqli, $date_arr);
}


if (false) {

    HZ_group::hz_update_sub_2_gr_by_date($sqltool, $date_arr);
    JSYS_group::jianshen_update_sub_2_gr_by_date($sqltool, $date_arr);
    JDJC_group::jdjc_update_nbr_2_gr_by_date($sqltool, $date_arr);
}


//JSYS_group::group_update($mysqli, $date_arr);
//JDJC_group::group_update($mysqli, $date_arr);

//XZCF_group::group_update_date_in($mysqli, $date_arr);
//XZCF_group::group_update_date_in($mysqli, "%2017-09%");

//HZDC_group::group_update_date_in($mysqli, $date_arr);
//HZDC_group::group_update_date_in($mysqli, "%2017-09%");


//HZ_group::group_update($mysqli, $date_arr);

echo HZ_group::dd_huizong_query_update($mysqli, $date_arr);

//$sqltool->do_not_gone_away();

