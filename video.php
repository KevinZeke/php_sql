<?php
/**
 * User: zhuangjiayu
 * Date: 2018/2/8
 * Time: 19:17
 */

require_once __DIR__ . '/Video/Video.php';
require_once __DIR__ . '/common/common.php';
require_once __DIR__ . '/map/Dadui_huizong_query_day.map.php';
Sql_tool::devopen();
//$data_arr = ['2017-01-01', '2018-02-08'];


//$sqltool_hazd = Sql_tool::build();
////质效跟踪数据库
//$sqltool_zxpg = Sql_tool::build(
//    'localhost', 'root', '123456', 'zxpg_gzpc_db'
//);


//efficiency($data_arr);
function video($mysqli_zxpg, $mysqli_hazd, $data_arr)
{
    $sqltool = Table_group::sqlTool_build($mysqli_zxpg);

    Video::$police_dd_map = get_police_dadui_map();

    Video::set_coef($sqltool);

    $sql = '';

//$row_handle = function ($row, &$sql, $type) {
//
//};

    Video::count_xzcf_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Video::row_handel($row, $sql, 'xzcf');
    });

    Video::count_jdjc_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Video::row_handel($row, $sql, 'jdjc');
    });

    Video::count_hzdc_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Video::row_handel($row, $sql, 'hzdc');
    });

    Video::count_shys_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Video::row_handel($row, $sql, 'jsys');
    });

    Video::count_aqjc_by_date($sqltool, $data_arr, function ($row) use (&$sql) {
        Video::row_handel($row, $sql, 'jsys');
    });

    Video::count_bacc($sqltool, function ($row) use (&$sql) {
        Video::row_handel($row, $sql, 'bacc');
    });

    if ($sql == '')
        return 0;
    return (new Table(Dadui_huizong_query_day_map::$table_name, Table_group::sqlTool_build($mysqli_hazd)))->multi_insert(
        [
            Dadui_huizong_query_day_map::$video_score,
            Dadui_huizong_query_day_map::$video_count,
            Dadui_huizong_query_day_map::$year_month_show,
            Dadui_huizong_query_day_map::$dd_name,
            Dadui_huizong_query_day_map::$police_name
        ],
        substr($sql, 1)
    );
}