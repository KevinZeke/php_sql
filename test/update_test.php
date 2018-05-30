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


/**
 * 使用：
 */
//建审验收的更新
//HZ_group::jdjc_group_update($mysqli, $date_arr);
//火灾调查的更新
//HZ_group::hzdc_group_update($mysqli, $date_arr);
//行政处罚的更新
HZ_group::xzcf_group_update($mysqli, $date_arr);
//监督检查的更新
//HZ_group::jdjc_group_update($mysqli, $date_arr);
//建审验收 火灾调查 行政处罚 监督检查 一起全部更新
//HZ_group::group_update($mysqli, $date_arr);
//如果更新成功会返回1,基本只要前端有返回就表示更新成功
//预计的调用后更新时间大概5-15分钟


//JSYS_group::group_update($mysqli, $date_arr);
//JDJC_group::group_update($mysqli, $date_arr);

//XZCF_group::group_update_date_in($mysqli, $date_arr);
//XZCF_group::group_update_date_in($mysqli, "%2017-09%");

//HZDC_group::group_update_date_in($mysqli, $date_arr);
//HZDC_group::group_update_date_in($mysqli, "%2017-09%");


//echo HZ_group::dd_huizong_query_update($mysqli, $date_arr);

//$sqltool->do_not_gone_away();


/**
 * @param string $date
 * @return array|string
 */
function format_date($date)
{
    $date_arr = explode('$', $date);
    if (count($date_arr) == 2) {
        return $date_arr;
    } else {
        return $date_arr[0];
    }
}

format_date('2018-09-09$2018-09-19');
format_date('2018-09');





