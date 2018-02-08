<?php
/**
 * User: zhuangjiayu
 * Date: 2018/2/8
 * Time: 19:17
 */

require_once __DIR__ . '/Efficiency/Efficiency.php';
require_once __DIR__ . '/common/common.php';
require_once __DIR__ . '/map/Dadui_huizong_query_day.map.php';
Sql_tool::devopen();
$data_arr = ['2017-01-01', '2018-02-08'];


//efficiency($data_arr);
function efficiency($mysqli_zxpg, $mysqli_hazd, $data_arr)
{
    $sqltool = Table_group::sqlTool_build($mysqli_zxpg);

    Efficiency::$police_dd_map = get_police_dadui_map();

    Efficiency::set_coef($sqltool);

    $sql = '';

//$row_handle = function ($row, &$sql, $type) {
//
//};

    Efficiency::count_xzcf_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Efficiency::row_handel($row, $sql, 'xzcf');
    });

    Efficiency::count_jdjc_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Efficiency::row_handel($row, $sql, 'jdjc');
    });

    Efficiency::count_hzdc_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Efficiency::row_handel($row, $sql, 'hzdc');
    });

    Efficiency::count_shys_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Efficiency::row_handel($row, $sql, 'jsys');
    });

    Efficiency::count_aqjc_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Efficiency::row_handel($row, $sql, 'jsys');
    });

    Efficiency::count_bacc($sqltool, function ($row) use (&$sql) {
        Efficiency::row_handel($row, $sql, 'bacc');
    });

    return (new Table(Dadui_huizong_query_day_map::$table_name, Table_group::sqlTool_build($mysqli_hazd)))->multi_insert(
        [
            Dadui_huizong_query_day_map::$efficiency_score,
            Dadui_huizong_query_day_map::$dd_name,
            Dadui_huizong_query_day_map::$police_name
        ],
        substr($sql, 1)
    );
}