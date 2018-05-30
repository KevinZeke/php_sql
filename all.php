<?php

require_once __DIR__ . '/All/ALL.php';
require_once __DIR__ . '/quality.php';
require_once __DIR__ . '/quantity.php';
require_once __DIR__ . '/efficiency.php';

ini_set("error_reporting","E_ALL & ~E_NOTICE");
//淮安支队数据库
$sqltool_hazd = Sql_tool::build();
//质效跟踪数据库
$sqltool_zxpg = Sql_tool::build(
    'localhost', 'root', '123456', 'zxpg_gzpc_db'
);
//不记录sql语句
//Sql_tool::devclose();
$date_arr = get_date($argc, $argv);
quality($sqltool_zxpg, $date_arr);
quantity($date_arr);
ALL::group_insert(
    $sqltool_hazd->get_mysqli(),
    $sqltool_zxpg->get_mysqli(),
    $date_arr
);
function get_date($argc, $argv)
{
    /**
     * 更新区间偏移量 - 7天
     */
    $offset = 7;

    $date = null;
    if ($argc == 2) {
        if ($argv[1] == "auto")
            $date = get_currnet_time($offset);
        else
            $date = $argv[1];
    } else if ($argc == 3) {
        $date = [$argv[1], $argv[2]];
    }

    if ($date)
        var_dump($date);
    else
        echo 'attention : no date(s) provided, 
        the program will reinsert all the data' . "\n";
    return $date;
}

function get_currnet_time($offset = 7)
{
    $cur_date = date("Y-m", time());
    $prev = date("Y-m-d", strtotime("-$offset day"));
    return [$prev, "$cur_date-31"];
}