<?php
/**
 * Created by zhuangjiayu.
 * User: zhuangjiayu
 * Date: 2018/1/29
 * Time: 12:02
 */


require_once __DIR__ . "/sql/Sql.class.php";
require_once __DIR__ . "/Quantity/JSYS.php";
require_once __DIR__ . "/Quantity/JDJC.php";
require_once __DIR__ . "/Quantity/HZ.php";


quantity_main($argc, $argv);

function quantity_main($argc, $argv)
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

    $sqltool = Sql_tool::build();
    $mysqli = $sqltool->get_mysqli();

    //    $sqltool->do_not_gone_away();

    echo ">>> jsys : inserting...\n";
    JSYS_group::group_insert($mysqli, $date);

    echo ">>> jdjc : inserting...\n";
    JDJC_group::group_insert($mysqli, $date);

    echo ">>> hz : inserting...\n";
    HZ_group::group_insert($mysqli, $date);

}

function get_currnet_time($offset = 7)
{
    $cur_date = date("Y-m", time());
    $prev = date("Y-m-d", strtotime("-$offset day"));
    return [$prev, "$cur_date-31"];
}

